<?php

namespace App\Http\Controllers;

use App\Models\Jumbotron;
use Illuminate\Http\Request;

class JumbotronController extends Controller
{
    //
    public function index()
    {
        $data = Jumbotron::first();
        return view('jumbotron.index', ['jumbotron' => $data]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:jumbotron,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $jumbotron = Jumbotron::updateOrCreate(
            ['id' => $validated['id'] ?? null],
            [
                'title' => $validated['title'],
                'description' => $validated['description'],
            ]
        );

        return response()->json([
            'message' => $validated['id'] ? 'Jumbotron updated successfully' : 'Jumbotron created successfully',
            'data' => $jumbotron
        ]);
    }
}
