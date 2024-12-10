<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarrierController extends Controller
{

    public function index()
    {
        $carriers = Carrier::with('services', 'incidents')->get();

        return view('carriers.index', compact('carriers'));
    }
}
