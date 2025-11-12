@extends('layouts.app')

@section('title', 'Asset Details - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">{{ $asset->name }}</h1>
                <p style="color: var(--gray-600);">Asset Details & QR Code</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('dashboard.assets.edit', $asset) }}" class="btn btn-secondary">Edit Asset</a>
                <a href="{{ route('dashboard.assets.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Asset Details -->
        <div class="card">
            <div class="card-header">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Asset Information</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label class="form-label">Asset Name</label>
                        <p style="color: var(--gray-900); font-weight: 500; margin-bottom: 1rem;">{{ $asset->name }}</p>
                    </div>

                    <div>
                        <label class="form-label">Instrument Type</label>
                        <p style="color: var(--gray-900); font-weight: 500; margin-bottom: 1rem;">{{ $asset->instrument_type }}</p>
                    </div>

                    <div>
                        <label class="form-label">Unit</label>
                        <p style="color: var(--gray-900); font-weight: 500; margin-bottom: 1rem;">{{ $asset->unit }}</p>
                    </div>

                    <div>
                        <label class="form-label">Jumlah</label>
                        <p style="color: var(--gray-900); font-weight: 500; margin-bottom: 1rem;">{{ $asset->jumlah }}</p>
                    </div>

                    <div>
                        <label class="form-label">Location</label>
                        <p style="color: var(--gray-900); font-weight: 500; margin-bottom: 1rem;">{{ $asset->location }}</p>
                    </div>

                    <div>
                        <label class="form-label">Status</label>
                        <span style="
                            padding: 0.25rem 0.75rem;
                            border-radius: 9999px;
                            font-size: 0.75rem;
                            font-weight: 500;
                            {{ $asset->status === 'active' ? 'background-color: #D1FAE5; color: #065F46;' : '' }}
                            {{ $asset->status === 'inactive' ? 'background-color: #FEE2E2; color: #991B1B;' : '' }}
                            {{ $asset->status === 'maintenance' ? 'background-color: #FEF3C7; color: #92400E;' : '' }}
                        ">
                            {{ ucfirst($asset->status) }}
                        </span>
                    </div>

                    <div>
                        <label class="form-label">QR Code</label>
                        <p style="color: var(--gray-900); font-weight: 500; margin-bottom: 1rem; font-family: monospace;">{{ $asset->qr_code }}</p>
                    </div>
                </div>

                @if($asset->description)
                    <div style="margin-top: 1.5rem;">
                        <label class="form-label">Description</label>
                        <p style="color: var(--gray-700); line-height: 1.6;">{{ $asset->description }}</p>
                    </div>
                @endif

                <div style="margin-top: 1.5rem;">
                    <label class="form-label">Created At</label>
                    <p style="color: var(--gray-600);">{{ $asset->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="card">
            <div class="card-header">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">QR Code</h3>
            </div>
            <div class="card-body">
                <div id="qrcode" style="text-align: center; margin-bottom: 1.5rem;"></div>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <button onclick="downloadQR()" class="btn btn-primary">Download QR Code</button>
                    <button onclick="printQR()" class="btn btn-secondary">Print QR Code</button>
                    <a href="{{ route('dashboard.assets.qr', $asset) }}" target="_blank" class="btn btn-secondary">View QR Data</a>
                </div>
            </div>
        </div>
    </div>
</div>

@vite('resources/js/app.js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const qrData = {
        id: {{ $asset->id }},
        name: '{{ addslashes($asset->name) }}',
        type: '{{ addslashes($asset->instrument_type) }}',
        location: '{{ addslashes($asset->location) }}',
        qr_code: '{{ $asset->qr_code }}',
        timestamp: '{{ now()->toISOString() }}'
    };

    const qrContainer = document.getElementById('qrcode');

    // Clear any existing content
    qrContainer.innerHTML = '';

    try {
        const canvas = document.createElement('canvas');
        canvas.width = 200;
        canvas.height = 200;
        qrContainer.appendChild(canvas);

        QRCode.toCanvas(canvas, JSON.stringify(qrData), {
            width: 200,
            height: 200,
            color: {
                dark: '#000000',
                light: '#FFFFFF'
            }
        }).then(() => {
            console.log('QR Code generated successfully');
        }).catch(error => {
            console.error('Error generating QR code:', error);
            showFallbackQR(qrContainer, qrData);
        });
    } catch (error) {
        console.error('Error creating QR code:', error);
        showFallbackQR(qrContainer, qrData);
    }

    function showFallbackQR(container, data) {
        container.innerHTML = '<div style="padding: 1rem; background: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">' +
            '<p style="margin: 0 0 0.5rem 0; font-weight: bold; color: #495057;">QR Code Data:</p>' +
            '<pre style="margin: 0; font-family: monospace; font-size: 0.875rem; color: #6c757d; white-space: pre-wrap; word-break: break-all;">' +
            JSON.stringify(data, null, 2) +
            '</pre></div>';
    }
});

function downloadQR() {
    const canvas = document.querySelector('#qrcode canvas');
    if (canvas) {
        const link = document.createElement('a');
        link.download = 'asset-{{ $asset->qr_code }}.png';
        link.href = canvas.toDataURL();
        link.click();
    }
}

function printQR() {
    const canvas = document.querySelector('#qrcode canvas');
    if (canvas) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body style="text-align: center;">');
        printWindow.document.write('<h2>{{ $asset->name }}</h2>');
        printWindow.document.write('<p>QR Code: {{ $asset->qr_code }}</p>');
        printWindow.document.write('<img src="' + canvas.toDataURL() + '" style="max-width: 300px;"/>');
        printWindow.document.write('<p>Type: {{ $asset->instrument_type }}</p>');
        printWindow.document.write('<p>Location: {{ $asset->location }}</p>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
}
</script>
@endsection
