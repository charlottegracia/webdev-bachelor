<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;

class IncidentController extends Controller
{
    public function index()
    {
        $incidents = Incident::with('carriers', 'services')->get();

        return response()->json($incidents);
    }

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

    public function show($id)
    {
        $incident = Incident::find($id);

        if (!$incident) {
            return response()->json(['error' => 'Incident not found'], 404);
        }

        //dd('Expected resolved at format: ' . $incident->expected_resolved_at . ' date now: ' . now());

        return response()->json($incident->load('carriers', 'services'), 200);
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

        return response()->json($incident->load('carriers', 'services'));
    }

     /**
     * Delete an incident.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $incident = Incident::find($id);

        if (!$incident) {
            return response()->json(['message' => 'Incident not found.'], 404);
        }

        $incident->carriers()->detach();
        $incident->services()->detach();

        $incident->delete();

        return response()->json(['message' => 'Incident deleted.'], 200);
    }
}