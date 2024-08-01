<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Vaccination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;

class VaccinationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MedicalRecord::class, 'medicalRecord');
    }
    /**
     * Display a listing of the resource.
     */
    public function index($patientId): View
    {
        $vaccinations = Vaccination::where('patient_id', $patientId)->get();
        return view('vaccinations.index', compact('vaccinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($patientId): View
    {
        return view('vaccinations.create', compact('patientId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $patientId): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Vaccination::create([
            'patient_id' => $patientId,
            'name' => $request->name,
            'date' => $request->date,
        ]);

        return redirect()->route('patients.show', $patientId)->with('success', 'Vaccination added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vaccination $vaccination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vaccination $vaccination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vaccination $vaccination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vaccination $vaccination)
    {
        //
    }
}
