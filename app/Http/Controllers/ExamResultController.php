<?php

namespace App\Http\Controllers;

use App\Models\ConsultationReport;
use App\Models\ExamResult;
use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MedicalRecord::class, 'medicalRecord');
    }
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $patient = User::findById($patient_id);
        $examResults = ExamResult::whereHas('medical_record', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })->get();
        return view('exam_results.index', compact('examResults'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exam_results.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $patient_id)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'result' => 'nullable|string',
            'doc' => 'nullable',
            'date' => 'nullable|date'
        ]);

        $medicalRecord = MedicalRecord::where('patient_id', $patient_id)->first();
        $medicalRecord_id = $medicalRecord->id;
        ExamResult::create([
            'medicalRecord_id' => $medicalRecord_id,
            'type' => $request->type,
            'result' => $request->result,
            'date' => $request->date
        ]);

        return redirect()->route('exam_results.index')->with('success', 'Exam result added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamResult $examResult)
    {
        return view('exam_results.show', compact('examResult'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamResult $examResult)
    {
        return view('exam_results.edit', compact('examResult'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamResult $examResult)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'result' => 'nullable|string',
            'doc' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif,svg,csv',
            'date' => 'nullable|date'
        ]);

        $examResult::update([
            'type' => $request->type,
            'value' => $request->value,
            'unit' => $request->unit
        ]);

        return redirect()->route('exam_results.index')->with('success', 'Exam result updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamResult $examResult)
    {
        $examResult->delete();

        return redirect()->route('exam_results.index')->with('success', 'Exam result deleted successfully.');
    }
}
