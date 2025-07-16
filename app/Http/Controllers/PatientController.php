<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:Male,Female,Unknown',
            'pacemaker' => 'required|in:Yes,No',
            'source' => 'required|in:Inpatient,Outpatient,Physical Exam'
        ]);

        Patient::create($request->all());
        return redirect()->route('patients.index')->with('success', 'Patient created successfully');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:Male,Female,Unknown',
            'pacemaker' => 'required|in:Yes,No',
            'source' => 'required|in:Inpatient,Outpatient,Physical Exam'
        ]);

        $patient->update($request->all());
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully');
    }
}