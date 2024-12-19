<?php

namespace App\Http\Controllers;

use App\Models\Polygon;
use Illuminate\Http\Request;

class PolygonController extends Controller
{
    public function index()
    {
        try {
            $polygons = Polygon::all();
            return response()->json($polygons);
        } catch (\Exception $e) {
            \Log::error('Error fetching polygons: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching polygons'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'coordinates' => 'required|array'
            ]);

            // Convert coordinates array to JSON string for storage
            $polygon = new Polygon();
            $polygon->name = $validatedData['name'];
            $polygon->coordinates = json_encode($validatedData['coordinates']);
            $polygon->save();

            return response()->json([
                'success' => true,
                'message' => 'Polygon created successfully',
                'data' => $polygon
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Error creating polygon: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $polygon = Polygon::findOrFail($id);
            $polygon->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Polygon deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting polygon: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting polygon'
            ], 500);
        }
    }
} 