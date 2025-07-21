<?php

use App\Models\EkgResult;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/ecg-result', function (Request $request) {
    if (!$request->hasFile('pdf')) {
        return response()->json(['status' => 'error', 'message' => 'No file uploaded'], 400);
    }

    $pdf = $request->file('pdf');

    if (!$pdf->isValid() || $pdf->getClientOriginalExtension() !== 'pdf') {
        return response()->json(['status' => 'error', 'message' => 'Invalid file'], 400);
    }

    $patientId = $request->input('patient_id');
    $examName = $request->input('exam_name');
    $studyDate = $request->input('study_date');

    $filename = now()->format('Ymd_His') . '_' . Str::slug($examName ?? 'ecg') . '_' . Str::random(6) . '.pdf';
    $path = $pdf->storeAs('public/ecg-results', $filename);

    // ✅ Save to DB
    EkgResult::create([
        'patient_id' => $patientId,
        'result_file_path' => $path,
        'examination_date' => $studyDate ? Carbon::parse($studyDate) : now(),
    ]);

    return response()->json(['status' => 'ok', 'message' => 'Result stored', 'filename' => $filename]);
});