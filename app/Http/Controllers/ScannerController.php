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

        $qrCode = $request->qr_code;
        $scannable = null;

        if (str_starts_with($qrCode, 'ASSET-')) {
            $scannable = \App\Models\Asset::where('qr_code', $qrCode)->first();
        } elseif (str_starts_with($qrCode, 'SET-')) {
            $scannable = \App\Models\InstrumentSet::where('qr_code', $qrCode)->with('assets')->first();
        }

        if (!$scannable) {
            return response()->json(['message' => 'QR Code not found or invalid'], 404);
        }

        $scanData = [
            'user_id' => auth()->id(),
            'action' => $request->action,
            'notes' => $request->notes,
            'location' => $request->location,
            'scanned_at' => now(),
        ];

        // Create the main scan activity for the set or asset
        $mainScanActivity = $scannable->scanActivities()->create($scanData);

        // Update the status based on the action
        $statusMap = [
            'Start Washing' => \App\Models\Asset::STATUS_WASHING,
            'Start Sterilizing' => \App\Models\Asset::STATUS_STERILIZING,
            'Mark as Ready' => \App\Models\Asset::STATUS_READY,
            'Mark as In Use' => \App\Models\Asset::STATUS_IN_USE,
            'Start Maintenance' => \App\Models\Asset::STATUS_MAINTENANCE,
        ];

        if (isset($statusMap[$request->action])) {
            $newStatus = $statusMap[$request->action];
            $scannable->update(['status' => $newStatus]);
        }

        Log::info('Item scanned', [
            'scannable_id' => $scannable->id,
            'scannable_type' => get_class($scannable),
            'user_id' => auth()->id(),
            'action' => $request->action,
        ]);

        // If it's an instrument set, also log an activity for each asset within it
        if ($scannable instanceof \App\Models\InstrumentSet) {
            if (isset($newStatus)) {
                $scannable->assets()->update(['status' => $newStatus]);
            }

            foreach ($scannable->assets as $asset) {
                $asset->scanActivities()->create($scanData);
                Log::info('Asset scanned as part of a set', [
                    'asset_id' => $asset->id,
                    'instrument_set_id' => $scannable->id,
                    'user_id' => auth()->id(),
                    'action' => $request->action,
                ]);
            }
        }

        return response()->json([
            'message' => 'Scan recorded successfully',
            'scan_activity' => $mainScanActivity->load('scannable', 'user'),
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
