<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Asset::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $assets = $query->latest()->paginate(10);
        return view('dashboard.assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instrumentTypes = \App\Models\InstrumentType::all();
        $units = \App\Models\Unit::all();
        $locations = \App\Models\Location::all();

        return view('dashboard.assets.create', compact('instrumentTypes', 'units', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'instrument_type' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $quantity = $request->input('jumlah', 1);

        for ($i = 0; $i < $quantity; $i++) {
            Asset::create([
                'name' => $request->name,
                'instrument_type' => $request->instrument_type,
                'unit' => $request->unit,
                'location' => $request->location,
                'description' => $request->description,
                'specifications' => $request->specifications,
                'qr_code' => 'ASSET-' . strtoupper(Str::uuid()->toString()),
            ]);
        }

        $message = $quantity > 1 ? "{$quantity} assets were created successfully." : 'Asset created successfully.';

        return redirect()->route('dashboard.assets.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        return view('dashboard.assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $instrumentTypes = \App\Models\InstrumentType::all();
        $units = \App\Models\Unit::all();
        $locations = \App\Models\Location::all();

        return view('dashboard.assets.edit', compact('asset', 'instrumentTypes', 'units', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'instrument_type' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $asset->update([
            'name' => $request->name,
            'instrument_type' => $request->instrument_type,
            'unit' => $request->unit,
            'location' => $request->location,
            'description' => $request->description,
            'specifications' => $request->specifications,
        ]);

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('dashboard.assets.index')->with('success', 'Asset deleted successfully.');
    }

    /**
     * Generate QR code for the asset.
     */
    public function generateQr(Asset $asset)
    {
        // Generate QR code data
        $qrData = [
            'id' => $asset->id,
            'name' => $asset->name,
            'type' => $asset->instrument_type,
            'location' => $asset->location,
            'qr_code' => $asset->qr_code,
            'timestamp' => now()->toISOString()
        ];

        return response()->json([
            'qr_data' => $qrData,
            'qr_string' => json_encode($qrData)
        ]);
    }

    /**
     * Get asset data by QR code for n8n integration.
     */
    public function getByQrCode($qrCode)
    {
        $asset = Asset::where('qr_code', $qrCode)->first();

        if (!$asset) {
            return response()->json([
                'error' => 'Asset not found',
                'message' => 'No asset found with QR code: ' . $qrCode
            ], 404);
        }

        return response()->json([
            'id' => $asset->id,
            'name' => $asset->name,
            'instrument_type' => $asset->instrument_type,
            'unit' => $asset->unit,
            'jumlah' => $asset->jumlah,
            'location' => $asset->location,
            'qr_code' => $asset->qr_code,
            'status' => $asset->status,
            'description' => $asset->description,
            'specifications' => $asset->specifications,
            'created_at' => $asset->created_at,
            'updated_at' => $asset->updated_at
        ]);
    }

    /**
     * Generate QR code from n8n request.
     */
    public function generateQrFromN8n(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'instrument_type' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $asset = new Asset();
        $asset->name = $request->name;
        $asset->instrument_type = $request->instrument_type;
        $asset->unit = $request->unit;
        $asset->jumlah = $request->jumlah;
        $asset->location = $request->location;
        $asset->description = $request->description;
        $asset->specifications = $request->specifications;
        $asset->status = $request->status;
        $asset->qr_code = 'ASSET-' . strtoupper(Str::uuid()->toString());
        $asset->save();

        // Generate QR code data
        $qrData = [
            'id' => $asset->id,
            'name' => $asset->name,
            'type' => $asset->instrument_type,
            'location' => $asset->location,
            'qr_code' => $asset->qr_code,
            'timestamp' => now()->toISOString()
        ];

        return response()->json([
            'asset' => $asset,
            'qr_data' => $qrData,
            'qr_string' => json_encode($qrData),
            'qr_code_url' => route('dashboard.assets.show', $asset)
        ]);
    }
}
