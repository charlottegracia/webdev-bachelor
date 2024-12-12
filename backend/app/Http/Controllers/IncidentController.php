<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;

class IncidentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'critical' => 'required|boolean',
            'country' => 'nullable|string',
            'type' => 'required|string',
            'status' => 'required|in:active,expired',
            'expected_resolved_at' => 'nullable|date',
            'resolved_at' => 'nullable|date',
            'carrier_ids' => 'nullable|array', 
            'carrier_ids.*' => 'exists:carriers,carrier_id',
            'service_ids' => 'nullable|array', 
            'service_ids.*' => 'exists:services,service_id', 
        ]);

        $incident = Incident::create($validated);

        return response()->json($incident->load('carriers', 'services'), 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'critical' => 'sometimes|required|boolean',
            'country' => 'nullable|string',
            'type' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:active,expired',
            'expected_resolved_at' => 'nullable|date',
            'resolved_at' => 'nullable|date',
        ]);

        $incident = Incident::findOrFail($id);
        $incident->update($validated); 

        return response()->json($incident->load('carriers'));
    }
}