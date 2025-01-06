<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrier;

class CarrierController extends Controller
{

    public function index()
    {
        $carriers = Carrier::with('services', 'incidents')->get();

        return response()->json($carriers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:carriers',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:green,yellow,red',
            'peak_up_charge' => 'nullable|numeric',
        ]);

        $carrier = Carrier::create($validated);

        return response()->json($carrier, 201);
    }

    // Show one carrier on id
    public function show($id)
    {
        $carrier = Carrier::find($id);

        if (!$carrier) {
            return response()->json(['error' => 'Carrier not found'], 404);
        }

        return response()->json($carrier->load('services', 'incidents'), 200);
    }

    /**
     * Update a carrier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'slug' => 'sometimes|required|string|max:50',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:green,yellow,red',
            'peak_up_charge' => 'nullable|numeric',
        ]);

        $carrier = Carrier::findOrFail($id);

        $carrier->update($validated);

        return response()->json($carrier->load('services', 'incidents'), 200);
    }

     /**
     * Delete a carrier.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $carrier = Carrier::find($id);

        if (!$carrier) {
            return response()->json(['message' => 'Carrier ikke fundet.'], 404);
        }

        $carrier->incidents()->detach();
        $carrier->services()->delete();
        $carrier->failureLogs()->delete();

        $carrier->delete();

        return response()->json(['message' => 'Carrier slettet.'], 200);
    }
}
