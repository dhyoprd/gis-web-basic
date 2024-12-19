<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function store(Request $request)
    {
        // Tambahkan log untuk debugging
        \Log::info('Data yang diterima:', $request->all());

        // Validasi input
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'nullable|string'
        ]);

        // Buat marker dengan data yang sudah divalidasi
        $marker = Marker::create($validated);

        return response()->json($marker);
    }

    public function index()
    {
        $markers = Marker::all();
        return response()->json($markers);
    }
} 