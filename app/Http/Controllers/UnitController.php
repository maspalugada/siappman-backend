<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = \App\Models\Unit::latest()->paginate(10);
        return view('dashboard.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units',
        ]);

        \App\Models\Unit::create($request->all());

        return redirect()->route('dashboard.units.index')->with('success', 'Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Unit $unit)
    {
        // Not implemented
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Unit $unit)
    {
        return view('dashboard.units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $unit->id,
        ]);

        $unit->update($request->all());

        return redirect()->route('dashboard.units.index')->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Unit $unit)
    {
        $unit->delete();

        return redirect()->route('dashboard.units.index')->with('success', 'Unit deleted successfully.');
    }
}
