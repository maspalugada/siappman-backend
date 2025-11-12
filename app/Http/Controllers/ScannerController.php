<?php

namespace App\Http\Controllers;

use App\Models\QRCode;
use App\Models\ScanActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScannerController extends Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'action' => 'required|string',
            'notes' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        $qrCode = QRCode::where('code', $request->qr_code)->first();

        if (!$qrCode) {
            return response()->json(['message' => 'QR Code not found'], 404);
        }

        if ($qrCode->status !== 'active') {
            return response()->json(['message' => 'QR Code is inactive'], 403);
        }

        $scanActivity = ScanActivity::create([
            'qr_id' => $qrCode->id,
            'user_id' => auth()->id(),
            'action' => $request->action,
            'notes' => $request->notes,
            'location' => $request->location,
            'scanned_at' => now(),
        ]);

        Log::info('QR Code scanned', [
            'qr_code_id' => $qrCode->id,
            'user_id' => auth()->id(),
            'action' => $request->action,
            'location' => $request->location,
        ]);

        return response()->json([
            'message' => 'Scan recorded successfully',
            'scan_activity' => $scanActivity->load('qrCode', 'user'),
        ]);
    }

    public function getScanHistory(Request $request)
    {
        $query = ScanActivity::with('qrCode', 'user');

        if ($request->has('qr_code')) {
            $query->whereHas('qrCode', function ($q) use ($request) {
                $q->where('code', $request->qr_code);
            });
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $scanActivities = $query->orderBy('scanned_at', 'desc')->paginate(20);

        return response()->json($scanActivities);
    }
}
