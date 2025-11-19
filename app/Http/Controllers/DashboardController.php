<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard');
    }

    public function qrCodes()
    {
        $assets = \App\Models\Asset::all();
        return view('dashboard.qr-codes', compact('assets'));
    }

    public function createQrCode()
    {
        return view('dashboard.qr-codes.create');
    }

    public function storeQrCode(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $qrCode = \App\Models\QRCode::create([
            'code' => \Illuminate\Support\Str::uuid()->toString(),
            'label' => $request->label,
            'location' => $request->location,
            'status' => 'active',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('dashboard.qr-codes')->with('success', 'QR Code created successfully!');
    }

    public function storeCombinedQrCode(Request $request)
    {
        $request->validate([
            'asset_ids' => 'required|array|min:1',
            'asset_ids.*' => 'exists:assets,id',
            'label' => 'required|string|max:255',
        ]);

        $assets = \App\Models\Asset::whereIn('id', $request->asset_ids)->get();

        // Create combined data
        $combinedData = [
            'type' => 'combined_assets',
            'assets' => $assets->map(function ($asset) {
                return [
                    'id' => $asset->id,
                    'name' => $asset->name,
                    'qr_code' => $asset->qr_code,
                    'location' => $asset->location,
                    'instrument_type' => $asset->instrument_type,
                ];
            })->toArray(),
            'timestamp' => now()->toISOString(),
        ];

        // Create QR code for combined assets
        $qrCode = \App\Models\QRCode::create([
            'code' => json_encode($combinedData),
            'label' => $request->label,
            'location' => 'Combined Assets',
            'status' => 'active',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('dashboard.qr-codes')->with('success', 'Combined QR Code created successfully!');
    }

    public function showQrCode($id)
    {
        // For now, just return the view
        // QR Code show logic will be implemented later
        return view('dashboard.qr-codes.show');
    }

    public function editQrCode($id)
    {
        // For now, just return the view
        // QR Code edit logic will be implemented later
        return view('dashboard.qr-codes.edit');
    }

    public function updateQrCode(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:text,url,phone,email',
        ]);

        // For now, just redirect back with success
        // QR Code update logic will be implemented later
        return redirect()->route('dashboard.qr-codes')->with('success', 'QR Code updated successfully!');
    }

    public function destroyQrCode($id)
    {
        // For now, just redirect back with success
        // QR Code delete logic will be implemented later
        return redirect()->route('dashboard.qr-codes')->with('success', 'QR Code deleted successfully!');
    }

    public function assets()
    {
        return view('dashboard.assets');
    }

    public function scanHistory()
    {
        $scanActivities = \App\Models\ScanActivity::with('scannable', 'user')
            ->latest('scanned_at')
            ->paginate(20);

        return view('dashboard.scan-history', compact('scanActivities'));
    }

    public function profile()
    {
        return view('dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
        ]);

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}
