<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::with('incidents')
        ->whereDoesntHave('carriers') 
        ->get();

        return response()->json($services);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:green,yellow,red',
            'carrier_ids' => 'nullable|array', 
            'carrier_ids.*' => 'exists:carriers,carrier_id', 
        ]);

        $service = Service::create($validated);

        if (!empty($validated['carrier_ids'])) {
            $service->carriers()->sync($validated['carrier_ids']);
        }

        return response()->json($service, 201); 
    }

    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        return response()->json($service);
    }

    /**
     * Update a service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:green,yellow,red',
        ]);

        $service = Service::findOrFail($id);

        $service->update($validated);

        return response()->json($service->load('carriers', 'incidents'), 200);
    }


    /**
     * Delete a service.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service ikke fundet.'], 404);
        }

        $service->carriers()->detach();
        $service->incidents()->detach();
        $service->failureLogs()->delete();

        $service->delete();

        return response()->json(['message' => 'Service slettet.'], 200);
    }
}