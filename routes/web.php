<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EkgController;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('patients', PatientController::class);
Route::resource('ekg', EkgController::class);
Route::get('/ekg/download/{id}', [EkgController::class, 'download'])->name('ekg.download');

Route::post('/send-to-worklist/{id}', function (Request $request, $id) {
    $patient = Patient::find($id);
    if (!$patient) {
        return response()->json(['success' => false, 'message' => 'Pasien tidak ditemukan.'], 404);
    }

    $response = Http::post('http://localhost:8080/insert-worklist', [
    'id' => $patient->id,
    'name' => $patient->name,
    'gender' => $patient->gender,
    'age' => $patient->age
    ]);

    if ($response->successful()) {
        $patient->isInWorklist = 1;
        $patient->save();
        return response()->json(['success' => true]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengirim ke Worklist Server.',
            'error' => $response->body()
        ], $response->status());
    }
    
    return response()->json(['success' => true]);
});