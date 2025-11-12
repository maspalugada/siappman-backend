<?php

namespace App\Http\Controllers;

use App\Models\QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;

class QRController extends Controller
{
    public function index()
    {
        $qrCodes = QRCode::with('creator')->get();
        return response()->json($qrCodes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $code = Str::uuid()->toString();

        $qrCode = QRCode::create([
            'code' => $code,
            'label' => $request->label,
            'location' => $request->location,
            'created_by' => auth()->id(),
        ]);

        return response()->json($qrCode, 201);
    }

    public function show(QRCode $qrCode)
    {
        return response()->json($qrCode->load('creator', 'scanActivities'));
    }

    public function update(Request $request, QRCode $qrCode)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $qrCode->update($request->only(['label', 'location', 'status']));

        return response()->json($qrCode);
    }

    public function destroy(QRCode $qrCode)
    {
        $qrCode->delete();
        return response()->json(['message' => 'QR Code deleted successfully']);
    }

    public function generate(QRCode $qrCode)
    {
        $qrCodeImage = QrCodeFacade::size(300)->generate($qrCode->code);
        return response($qrCodeImage)->header('Content-Type', 'image/svg+xml');
    }
}
