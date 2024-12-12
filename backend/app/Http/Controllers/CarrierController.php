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
        //return view('carriers.index', compact('carriers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:carriers',
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:green,yellow,red',
            'peak_up_charge' => 'nullable|numeric',
        ]);

        $carrier = Carrier::create($validated);

        return response()->json($carrier, 201);
    }

    public function show($id)
    {
        $carrier = Carrier::find($id);

        if (!$carrier) {
            return response()->json(['error' => 'Carrier not found'], 404);
        }

        return response()->json($carrier);
    }
}
