<?php

namespace App\Http\Controllers;

use App\Models\PrescriptionLine;
use Illuminate\Http\Request;

class PrescriptionLineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prescription_id = $request->prescription_id;
        $this->authorize('create', [PrescriptionLine::class, $prescription_id]);
        $request->validate([
            'name' => 'required|string',
            'dose' => 'required|string',
            'duration' => 'required|string',
        ]);

        $line = new PrescriptionLine($request->only('name', 'dose', 'duration'));
        $line->prescription_id = $prescription_id;
        $line->save();

        return response()->json(['success' => true, 'line' => $line]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PrescriptionLine $perscriptionLine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrescriptionLine $perscriptionLine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrescriptionLine $perscriptionLine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrescriptionLine $perscriptionLine)
    {
        //
    }
}
