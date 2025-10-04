<?php

namespace App\Http\Controllers;

use App\Models\GoogleIntegration;
use App\Models\Plan;
use Google\Client as GoogleClient;
use Google\Service\Calendar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GoogleIntegrationController extends Controller
{
    private function getGoogleClient(): GoogleClient
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->addScope(Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        
        return $client;
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        $client = $this->getGoogleClient();
        $authUrl = $client->createAuthUrl();
        
        return redirect()->away($authUrl);
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleCallback(Request $request): RedirectResponse
    {
        if (!$request->has('code')) {
            return redirect()
                ->route('plans.index')
                ->with('error', 'Error al conectar con Google Calendar.');
        }

        try {
            $client = $this->getGoogleClient();
            $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

            if (isset($token['error'])) {
                return redirect()
                    ->route('plans.index')
                    ->with('error', 'Error de autenticación: ' . $token['error']);
            }

            // Guardar tokens en la base de datos
            GoogleIntegration::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'] ?? null,
                    'token_expires_at' => now()->addSeconds($token['expires_in']),
                ]
            );

            return redirect()
                ->route('plans.index')
                ->with('success', '¡Google Calendar conectado exitosamente!');
        } catch (\Exception $e) {
            return redirect()
                ->route('plans.index')
                ->with('error', 'Error al conectar: ' . $e->getMessage());
        }
    }

    /**
     * Export plan to Google Calendar.
     */
    public function exportPlanToCalendar(Plan $plan): RedirectResponse
    {
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }

        $integration = GoogleIntegration::where('user_id', auth()->id())->first();

        if (!$integration) {
            return redirect()
                ->route('plans.show', $plan)
                ->with('error', 'Primero debes conectar tu cuenta de Google Calendar.');
        }

        try {
            $client = $this->getGoogleClient();
            $client->setAccessToken($integration->access_token);

            // Refrescar token si expiró
            if ($client->isAccessTokenExpired()) {
                if ($integration->refresh_token) {
                    $client->fetchAccessTokenWithRefreshToken($integration->refresh_token);
                    $newToken = $client->getAccessToken();
                    
                    $integration->update([
                        'access_token' => $newToken['access_token'],
                        'token_expires_at' => now()->addSeconds($newToken['expires_in']),
                    ]);
                } else {
                    return redirect()
                        ->route('google.redirect')
                        ->with('error', 'Token expirado. Reconectando...');
                }
            }

            $service = new Calendar($client);
            $plan->load('planItems.recipe');

            $eventsCreated = 0;
            foreach ($plan->planItems as $planItem) {
                if (!$planItem->recipe) {
                    continue;
                }

                // Calcular fecha y hora del evento
                $dayOffset = $planItem->day_of_week - 1;
                $eventDate = $plan->start_date->copy()->addDays($dayOffset);
                
                // Asignar horarios según tipo de comida
                $startHour = match($planItem->meal_order) {
                    1 => '08:00',
                    2 => '13:00',
                    3 => '20:00',
                    default => '12:00',
                };

                $event = new Calendar\Event([
                    'summary' => $planItem->recipe->title,
                    'description' => $planItem->recipe->description . "\n\nCalorías: " . number_format($planItem->recipe->total_calories ?? 0, 0) . " kcal",
                    'start' => [
                        'dateTime' => $eventDate->format('Y-m-d') . 'T' . $startHour . ':00',
                        'timeZone' => config('app.timezone'),
                    ],
                    'end' => [
                        'dateTime' => $eventDate->format('Y-m-d') . 'T' . date('H:i', strtotime($startHour) + 3600) . ':00',
                        'timeZone' => config('app.timezone'),
                    ],
                ]);

                $service->events->insert('primary', $event);
                $eventsCreated++;
            }

            return redirect()
                ->route('plans.show', $plan)
                ->with('success', "¡{$eventsCreated} eventos exportados a Google Calendar!");
        } catch (\Exception $e) {
            return redirect()
                ->route('plans.show', $plan)
                ->with('error', 'Error al exportar: ' . $e->getMessage());
        }
    }
}
