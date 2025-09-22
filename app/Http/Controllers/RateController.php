<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rates = Rate::where('is_active', true)->latest()->paginate(10);
        return view('rates.index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rates,name',
            'amount' => 'required|numeric|min:0',
            'amount_exceeded' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $validated['is_active'] = true;
        
        Rate::create($validated);

        return redirect()->route('rates.index')
            ->with('success', 'Tarifa creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rate $rate)
    {
        return view('rates.show', compact('rate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rate $rate)
    {
        return view('rates.edit', compact('rate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rate $rate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rates,name,' . $rate->id,
            'amount' => 'required|numeric|min:0',
            'amount_exceeded' => 'required|numeric|min:0',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $rate->update($validated);

        return redirect()->route('rates.index')
            ->with('success', 'Tarifa actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rate $rate)
    {
        $rate->update(['is_active' => false]);

        return redirect()->route('rates.index')
            ->with('success', 'Tarifa desactivada exitosamente.');
    }
}
