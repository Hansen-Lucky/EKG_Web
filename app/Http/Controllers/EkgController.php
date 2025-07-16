<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\EkgResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkgController extends Controller
{
    public function index()
    {
        $ekgResults = EkgResult::with('patient')->get();
        return view('ekg.index', compact('ekgResults'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('ekg.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'result_file' => 'required|file|mimes:pdf|max:2048',
            'examination_date' => 'required|date'
        ]);

        $file = $request->file('result_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('ekg_results', $fileName, 'public');

        EkgResult::create([
            'patient_id' => $request->patient_id,
            'result_file_path' => $filePath,
            'examination_date' => $request->examination_date
        ]);

        return redirect()->route('ekg.index')->with('success', 'EKG result created successfully');
    }

    public function download($id)
    {
        $ekgResult = EkgResult::findOrFail($id);
        $filePath = storage_path('app/public/' . $ekgResult->result_file_path);
        
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        
        return abort(404, 'File not found');
    }

    public function destroy(EkgResult $ekgResult)
    {
        // Hapus file dari storage
        if (Storage::disk('public')->exists($ekgResult->result_file_path)) {
            Storage::disk('public')->delete($ekgResult->result_file_path);
        }
        
        $ekgResult->delete();
        return redirect()->route('ekg.index')->with('success', 'EKG result deleted successfully');
    }
}