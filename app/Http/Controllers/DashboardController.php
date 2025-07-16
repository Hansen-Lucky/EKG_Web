<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\EkgResult;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $totalEkgResults = EkgResult::count();
        
        return view('dashboard.index', compact('totalPatients', 'totalEkgResults'));
    }
}