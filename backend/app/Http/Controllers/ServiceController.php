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
            'type' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:green,yellow,red',
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
}