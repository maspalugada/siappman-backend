<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstrumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instrumentTypes = \App\Models\InstrumentType::latest()->paginate(10);
        return view('dashboard.instrument-types.index', compact('instrumentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.instrument-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:instrument_types',
        ]);

        \App\Models\InstrumentType::create($request->all());

        return redirect()->route('dashboard.instrument-types.index')->with('success', 'Instrument type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\InstrumentType $instrumentType)
    {
        return view('dashboard.instrument-types.show', compact('instrumentType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\InstrumentType $instrumentType)
    {
        return view('dashboard.instrument-types.edit', compact('instrumentType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\InstrumentType $instrumentType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:instrument_types,name,' . $instrumentType->id,
        ]);

        $instrumentType->update($request->all());

        return redirect()->route('dashboard.instrument-types.index')->with('success', 'Instrument type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\InstrumentType $instrumentType)
    {
        $instrumentType->delete();

        return redirect()->route('dashboard.instrument-types.index')->with('success', 'Instrument type deleted successfully.');
    }
}
