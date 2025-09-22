<?php

namespace App\Http\Controllers;

use App\Models\Prosecutor;
use App\Models\User;
use Illuminate\Http\Request;

class ProsecutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prosecutors = Prosecutor::where('is_active', true)->latest()->paginate(10);
        return view('prosecutors.index', compact('prosecutors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('prosecutors.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => 'required|string|unique:prosecutors,dni',
            'phone' => 'required|string|max:20',
            'user_id' => 'required|exists:users,id',
        ]);

        $validated['is_active'] = true;
        
        Prosecutor::create($validated);

        return redirect()->route('prosecutors.index')
            ->with('success', 'Fiscal creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prosecutor $prosecutor)
    {
        return view('prosecutors.show', compact('prosecutor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prosecutor $prosecutor)
    {
        return view('prosecutors.edit', compact('prosecutor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prosecutor $prosecutor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => 'required|string|unique:prosecutors,dni,' . $prosecutor->id,
            'phone' => 'required|string|max:20',
            'is_active' => 'boolean',
            'user_id' => 'required|exists:users,id',
        ]);

        $prosecutor->update($validated);

        return redirect()->route('prosecutors.index')
            ->with('success', 'Fiscal actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prosecutor $prosecutor)
    {
        $prosecutor->update(['is_active' => false]);

        return redirect()->route('prosecutors.index')
            ->with('success', 'Fiscal desactivado exitosamente.');
    }
}
