<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Events\ConsultationStarted;
use App\Mail\AppointmentMail;
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
use Illuminate\Support\Facades\Auth;
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
        $doctorToken = $this->generateLiveKitToken($apiKey, $apiSecret, $roomName, $doctorIdentity);

        // Générer le token pour le patient
        $patientToken = $this->generateLiveKitToken($apiKey, $apiSecret, $roomName, $patientIdentity);

        // Mettre à jour le statut du rendez-vous et stocker les tokens
        $appointment->doctor_token = $doctorToken;
        $appointment->patient_token = $patientToken;
        $appointment->status = AppointmentStatus::STARTED;
        $appointment->save();

        // URL pour rejoindre la consultation
        $joinUrl = route('consultations.join', ['appointment_id' => $appointment->id]);

        // Envoyer une notification au patient via event
        event(new ConsultationStarted($appointment, $joinUrl));

        // Envoyer une notification au patient via un email
        Mail::to($appointment->patient->email)->send(new ConsultationStartedMail($appointment, $joinUrl));

        return redirect()->route('consultation.room', ['appointment_id' => $appointment->id]);

    }

    public function showConsultationRoom($appointmentId): View
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Pass the doctor token to the view
        return view('consultation.room', compact('appointment'), ['doctorToken' => $appointment->doctor_token, 'patientToken' => $appointment->patient_token]);
    }

    /**
     * Générer un token JWT pour LiveKit.
     *
     * @param string $apiKey
     * @param string $apiSecret
     * @param string $roomName
     * @param string $identity
     * @return string
     * @throws Exception
     */
    private function generateLiveKitToken(string $apiKey, string $apiSecret, string $roomName, string $identity): string
    {// Define the token options
        $tokenOptions = (new AccessTokenOptions())
            ->setIdentity($identity);

        // Define the video grants
        $videoGrant = (new VideoGrant())
            ->setRoomJoin(true)
            ->setRoomName($roomName)
            ->setCanPublish(true)
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
     * @param Request $request
     * @param int $appointmentId
     * @return RedirectResponse
     */
    public function joinOnlineConsultation(Request $request, int $appointmentId): RedirectResponse
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $user = Auth::user();

        // Check if the user is the doctor or patient for this appointment
        if ($user->id !== $appointment->doctor_id && $user->id !== $appointment->patient_id) {
            abort(403, 'Unauthorized');
        }

        // Proceed with the consultation
        return redirect()->route('consultation.room', ['appointment_id' => $appointment->id]);
    }

    public function completeAppointment(Request $request, $appointmentId): JsonResponse
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = AppointmentStatus::COMPLETED;
        $appointment->save();

        return response()->json(['message' => 'Appointment status updated to completed']);
    }
}
