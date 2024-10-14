<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExamResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $patient = User::findById($patient_id);
        $this->authorize('view', $patient->medicalRecord);
        $examResults = ExamResult::whereHas('medical_record', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })->get();
        return view('exam_results.index', compact('examResults'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($medicalRecord_id)
    {
        $medicalRecord = MedicalRecord::findOrFail($medicalRecord_id);
        $patient = $medicalRecord->patient;

        $this->authorize('create', [ExamResult::class, $patient->id]);

        return view('exam_results.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $medicalRecord_id)
    {
        $medicalRecord = MedicalRecord::findOrFail($medicalRecord_id);
        $patient = $medicalRecord->patient;

        $this->authorize('create', [ExamResult::class, $patient->id]);

        $validatedData = $request->validate([
            'type'   => 'required|string|max:255',
            'result' => 'nullable|string',
            'doc'    => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
            'date'   => 'nullable|date',
        ]);

        if ($request->hasFile('doc')) {
            $file = $request->file('doc');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('exam_results', $filename, 'public');
            $validatedData['doc'] = $filepath;
        }

        $validatedData['medicalRecord_id'] = $medicalRecord_id;
        ExamResult::create($validatedData);

        return redirect()->back();
//        return redirect()->route('exam_results.index')->with('success', 'Exam result added successfully.');
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
    public function update(Request $request, $examResult_id)
    {
        $examResult = ExamResult::findOrFail($examResult_id);
        $this->authorize('update', $examResult);

        $validatedData = $request->validate([
            'type'   => 'required|string|max:255',
            'result' => 'nullable|string',
            'doc'    => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
            'date'   => 'nullable|date',
        ]);

        $examResult->update($validatedData);

        if ($request->hasFile('doc')) {

            if ($examResult->doc) {
                Storage::disk('public')->delete($examResult->doc);
            }
            $file = $request->file('doc');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('exam_results', $filename, 'public');
            $examResult->doc = $path;
        }
        $examResult->save();

        return redirect()->back();
//        return redirect()->route('exam_results.index')->with('success', 'Exam result updated successfully.');
    }

    public function downloadDoc($doc)
    {
        // Retrieve the path to the document
        $filePath = 'exam_results/' . $doc;

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'Le document n\'existe pas.');
        }

//        return Storage::download($filePath);
        return response()->download($filePath);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($examResult_id)
    {
        $examResult = ExamResult::findOrFail($examResult_id);
        $this->authorize('delete', $examResult);

        $examResult->delete();

        return redirect()->back();
//        return redirect()->route('exam_results.index')->with('success', 'Exam result deleted successfully.');
    }
}
