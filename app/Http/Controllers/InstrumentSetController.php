<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstrumentSetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instrumentSets = \App\Models\InstrumentSet::withCount('assets')->latest()->paginate(10);
        return view('dashboard.instrument-sets.index', compact('instrumentSets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = \App\Models\Asset::orderBy('name')->get();
        return view('dashboard.instrument-sets.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assets' => 'nullable|array',
            'assets.*' => 'exists:assets,id',
        ]);

        $instrumentSet = \App\Models\InstrumentSet::create([
            'name' => $request->name,
            'description' => $request->description,
            'qr_code' => 'SET-' . strtoupper(\Illuminate\Support\Str::uuid()->toString()),
        ]);

        if ($request->has('assets')) {
            $instrumentSet->assets()->attach($request->assets);
        }

        return redirect()->route('dashboard.instrument-sets.index')->with('success', 'Instrument set created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\InstrumentSet $instrumentSet)
    {
        $instrumentSet->load('assets');
        return view('dashboard.instrument-sets.show', compact('instrumentSet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\InstrumentSet $instrumentSet)
    {
        $assets = \App\Models\Asset::orderBy('name')->get();
        $instrumentSet->load('assets');
        return view('dashboard.instrument-sets.edit', compact('instrumentSet', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\InstrumentSet $instrumentSet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assets' => 'nullable|array',
            'assets.*' => 'exists:assets,id',
        ]);

        $instrumentSet->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $instrumentSet->assets()->sync($request->assets ?? []);

        return redirect()->route('dashboard.instrument-sets.index')->with('success', 'Instrument set updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\InstrumentSet $instrumentSet)
    {
        $instrumentSet->delete();
        return redirect()->route('dashboard.instrument-sets.index')->with('success', 'Instrument set deleted successfully.');
    }
}
