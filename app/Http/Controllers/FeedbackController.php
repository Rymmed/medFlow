<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class FeedbackController extends Controller
{
    public function create($doctor_id)
    {
        $doctor = User::findOrFail($doctor_id);
        $feedbacks = Feedback::where('doctor_id', $doctor_id)->get();

        // Calculer la moyenne des notes
        $averageRating = round($doctor->averageRating(), 2);

        return view('patient.feedback', compact('doctor', 'feedbacks', 'averageRating'));
    }

    public function store(Request $request)
    {
        // Valider les données d'entrée
        $validatedData = $request->validate([
            'comment' => 'required|string|max:1000',
            'doctor_id' => 'required|exists:users,id'
        ]);
        // Appeler l'API de prédiction de la note
        $response = Http::post('https://a347-35-231-154-155.ngrok-free.app/predict', [
            'comment' => $request->comment,
        ]);

        // Vérifier si l'appel API a réussi
        if ($response->successful() && isset($response->json()['score'])) {
            $rating = $response->json()['score'];
        } else {
            return redirect()->back()->withErrors('Impossible d\'obtenir une note de l\'API.');
        }

        // Créer le feedback en associant le médecin et le patient
        Feedback::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => Auth::id(),
            'comment' => $validatedData['comment'],
            'rating' => $rating,
        ]);

        // Rediriger ou retourner une réponse appropriée
        return redirect()->back()->with('success', 'Votre feedback a été soumis avec succès.');
    }

    // Calculer la moyenne des notes d'un médecin
    protected function getAverageRating($doctor_id)
    {
        $averageRating = Feedback::where('doctor_id', $doctor_id)->avg('rating');
        return round($averageRating, 2); // Arrondir à 2 décimales
    }
}
