<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarkerController extends Controller
{
    public function index()
    {
        try {
            $markers = Marker::all();
            return response()->json($markers, 200, [], JSON_NUMERIC_CHECK);
        } catch (\Exception $e) {
            Log::error('Error fetching markers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching markers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $marker = Marker::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Marker created successfully',
                'data' => $marker
            ], 201, [], JSON_NUMERIC_CHECK);
        } catch (\Exception $e) {
            Log::error('Error creating marker: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating marker',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            \Log::info('Attempting to delete marker with ID: ' . $id);
            
            $marker = Marker::findOrFail($id);
            $marker->delete();
            
            \Log::info('Marker deleted successfully');
            
            return response()->json([
                'success' => true,
                'message' => 'Marker deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Marker not found with ID: ' . $id);
            return response()->json([
                'success' => false,
                'message' => 'Marker not found'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Error deleting marker: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting marker: ' . $e->getMessage()
            ], 500);
        }
    }
} 