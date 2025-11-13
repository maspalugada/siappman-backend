@extends('layouts.app')

@section('title', $instrumentSet->name . ' - Instrument Sets - SiAPPMan')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">{{ $instrumentSet->name }}</h1>
            <p style="color: var(--gray-600);">Set Details</p>
        </div>
        <a href="{{ route('dashboard.instrument-sets.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
                <div>
                    <h3 style="font-weight: 600; margin-bottom: 1rem;">QR Code</h3>
                    <div id="qrCodeContainer" style="border: 1px solid var(--gray-200); padding: 1rem; border-radius: 0.5rem; text-align: center;"></div>
                    <p style="text-align: center; margin-top: 1rem; font-family: monospace; color: var(--gray-700);">{{ $instrumentSet->qr_code }}</p>
                </div>
                <div>
                    <h3 style="font-weight: 600; margin-bottom: 1rem;">Details</h3>
                    <p><strong>Description:</strong><br>{{ $instrumentSet->description ?? 'N/A' }}</p>
                    <p><strong>Created At:</strong> {{ $instrumentSet->created_at->format('d M Y, H:i') }}</p>

                    <hr style="margin: 2rem 0;">

                    <h3 style="font-weight: 600; margin-bottom: 1rem;">Assets in this Set ({{ $instrumentSet->assets->count() }})</h3>
                    <ul>
                        @forelse($instrumentSet->assets as $asset)
                            <li>{{ $asset->name }} ({{ $asset->instrument_type }})</li>
                        @empty
                            <li>No assets have been added to this set.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/qrcode.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new QRCode(document.getElementById('qrCodeContainer'), {
            text: "{{ $instrumentSet->qr_code }}",
            width: 200,
            height: 200,
        });
    });
</script>
@endsection
