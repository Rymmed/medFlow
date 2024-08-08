<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Events\ConsultationStarted;
use App\Mail\ConsultationStartedMail;
use App\Models\Appointment;
use App\Notifications\ConsultationNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;
use Illuminate\Http\Response;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    /**
     * Démarrer la consultation en ligne.
     *
     * @param Request $request
     * @param int $appointmentId
     * @return RedirectResponse
     * @throws Exception
     */
    public function startOnlineConsultation(Request $request, int $appointmentId): RedirectResponse
    {
        $appointment = Appointment::findOrFail($appointmentId);

        $apiKey = env('LIVEKIT_API_KEY');
        $apiSecret = env('LIVEKIT_API_SECRET');
        $roomName = 'consultation_room_' . $appointment->id;
        $doctorIdentity = 'doctor_' . $appointment->doctor_id;
        $patientIdentity = 'patient_' . $appointment->patient_id;

        // Générer le token pour le docteur
        $doctorToken = $this->generateLiveKitToken($apiKey, $apiSecret, $roomName, $doctorIdentity, true);

        // Générer le token pour le patient
        $patientToken = $this->generateLiveKitToken($apiKey, $apiSecret, $roomName, $patientIdentity, false);

        // Mettre à jour le statut du rendez-vous et stocker les tokens
        $appointment->doctor_token = $doctorToken;
        $appointment->patient_token = $patientToken;
        $appointment->status = AppointmentStatus::STARTED;
        $appointment->save();

        // Envoyer une notification au patient via l'événement
        event(new ConsultationStarted($appointment));
        // URL pour rejoindre la consultation
        $joinUrl = route('consultation.room', ['appointment_id' => $appointment->id]);

        // Envoyer une notification au patient via un email
        Mail::to($appointment->patient->email)->send(new ConsultationStartedMail($appointment, $joinUrl));

        return redirect()->route('consultation.room', ['appointment_id' => $appointment->id]);

    }
    public function showConsultationRoom($appointmentId): View
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Pass the doctor token to the view
        return view('consultation.room', ['doctorToken' => $appointment->doctor_token, 'patientToken' => $appointment->patient_token]);
    }
    /**
     * Générer un token JWT pour LiveKit.
     *
     * @param string $apiKey
     * @param string $apiSecret
     * @param string $roomName
     * @param string $identity
     * @param bool $canPublish
     * @return string
     * @throws Exception
     */
    private function generateLiveKitToken(string $apiKey, string $apiSecret, string $roomName, string $identity, bool $canPublish): string
    {
        // Define the token options
        $tokenOptions = (new AccessTokenOptions())
            ->setIdentity($identity);

        // Define the video grants
        $videoGrant = (new VideoGrant())
            ->setRoomJoin(true)
            ->setRoomName($roomName)
            ->setCanPublish($canPublish)
            ->setCanSubscribe(true);

        // Initialize and fetch the JWT Token
        return (new AccessToken($apiKey, $apiSecret))
            ->init($tokenOptions)
            ->setGrant($videoGrant)
            ->toJwt();
    }

    /**
     * Joindre la consultation en ligne (pour le patient).
     *
     * @param int $appointmentId
     * @return RedirectResponse
     */
    public function joinOnlineConsultation(int $appointmentId): RedirectResponse
    {
        // Récupérer le rendez-vous par son ID
        $appointment = Appointment::findOrFail($appointmentId);

        // Retourner le token du patient pour rejoindre l'appel
//        return response()->json([
//            'patient_token' => $appointment->patient_token,
//            'message' => 'You can join the consultation.',
//        ]);
        return redirect()->route('consultation.room', ['appointment_id' => $appointment->id]);
    }
}
