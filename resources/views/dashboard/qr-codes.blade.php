@extends('layouts.app')

@section('title', 'QR Codes - SiAPPMan')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">QR Codes</h1>
            <p style="color: var(--gray-600);">Manage your QR codes</p>
        </div>
        <a href="{{ route('dashboard.qr-codes.create') }}" class="btn btn-primary">
            <span style="margin-right: 0.5rem;">+</span>
            Create QR Code
        </a>
    </div>

    @if($assets->count() > 0)
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Asset QR Codes</h3>
                    <div style="display: flex; gap: 0.5rem;">
                        <button onclick="selectAll()" class="btn btn-secondary btn-sm">Select All</button>
                        <button onclick="downloadSelected()" class="btn btn-primary btn-sm" id="downloadSelectedBtn" style="display: none;">Download Selected</button>
                        <button onclick="printSelected()" class="btn btn-secondary btn-sm" id="printSelectedBtn" style="display: none;">Print Selected</button>
                        <button onclick="createCombinedQR()" class="btn btn-success btn-sm" id="createCombinedBtn" style="display: none;">Create Combined QR</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                    @foreach($assets as $asset)
                        <div class="card qr-card" style="border: 1px solid var(--gray-200);" data-asset-id="{{ $asset->id }}">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                    <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                                        <input type="checkbox" class="qr-checkbox" data-asset-id="{{ $asset->id }}" onchange="updateSelection()">
                                        <div>
                                            <h4 style="font-size: 1.125rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem;">{{ $asset->name }}</h4>
                                            <p style="color: var(--gray-600); font-size: 0.875rem;">{{ $asset->location }}</p>
                                            <p style="color: var(--gray-500); font-size: 0.75rem;">{{ $asset->instrument_type }}</p>
                                        </div>
                                    </div>
                                    <span class="badge {{ $asset->status === 'active' ? 'badge-success' : 'badge-secondary' }}">{{ ucfirst($asset->status) }}</span>
                                </div>
                                <div id="qrcode-{{ $asset->id }}" style="text-align: center; margin-bottom: 1rem;"></div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <button onclick="downloadQR('{{ $asset->id }}', '{{ $asset->qr_code }}')" class="btn btn-secondary btn-sm">Download</button>
                                    <button onclick="printQR('{{ $asset->id }}', '{{ $asset->name }}', '{{ $asset->qr_code }}')" class="btn btn-secondary btn-sm">Print</button>
                                    <a href="{{ route('dashboard.assets.show', $asset) }}" class="btn btn-primary btn-sm">View Asset</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div style="text-align: center; color: var(--gray-500); padding: 3rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📱</div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.5rem;">No QR Codes Yet</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Create your first QR code to get started</p>
                    <a href="{{ route('dashboard.qr-codes.create') }}" class="btn btn-primary">Create Your First QR Code</a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
let selectedAssets = [];
const assetsData = @json($assets);

document.addEventListener('DOMContentLoaded', function() {
    @foreach($assets as $asset)
        const qrData{{ $asset->id }} = {
            id: {{ $asset->id }},
            name: '{{ $asset->name }}',
            type: '{{ $asset->instrument_type }}',
            location: '{{ $asset->location }}',
            qr_code: '{{ $asset->qr_code }}',
            timestamp: '{{ now()->toISOString() }}'
        };

        const qrContainer{{ $asset->id }} = document.getElementById('qrcode-{{ $asset->id }}');
        if (qrContainer{{ $asset->id }}) {
            try {
                const canvas = document.createElement('canvas');
                canvas.width = 150;
                canvas.height = 150;
                qrContainer{{ $asset->id }}.appendChild(canvas);

                QRCode.toCanvas(canvas, JSON.stringify(qrData{{ $asset->id }}), {
                    width: 150,
                    height: 150,
                    color: {
                        dark: '#000000',
                        light: '#FFFFFF'
                    }
                }).catch(function(error) {
                    console.error('Error generating QR code for asset {{ $asset->id }}:', error);
                    qrContainer{{ $asset->id }}.innerHTML = '<p style="color: red; font-size: 12px;">Error generating QR code</p>';
                });
            } catch (error) {
                console.error('Error generating QR code for asset {{ $asset->id }}:', error);
                qrContainer{{ $asset->id }}.innerHTML = '<p style="color: red; font-size: 12px;">Error generating QR code</p>';
            }
        }
    @endforeach
});

function updateSelection() {
    selectedAssets = [];
    document.querySelectorAll('.qr-checkbox:checked').forEach(checkbox => {
        selectedAssets.push(parseInt(checkbox.dataset.assetId));
    });

    const downloadBtn = document.getElementById('downloadSelectedBtn');
    const printBtn = document.getElementById('printSelectedBtn');
    const createCombinedBtn = document.getElementById('createCombinedBtn');

    if (selectedAssets.length > 0) {
        downloadBtn.style.display = 'inline-block';
        printBtn.style.display = 'inline-block';
        createCombinedBtn.style.display = 'inline-block';
    } else {
        downloadBtn.style.display = 'none';
        printBtn.style.display = 'none';
        createCombinedBtn.style.display = 'none';
    }
}

function selectAll() {
    const checkboxes = document.querySelectorAll('.qr-checkbox');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });

    updateSelection();
}

function downloadSelected() {
    if (selectedAssets.length === 0) return;

    if (selectedAssets.length === 1) {
        // Single QR code download
        const id = selectedAssets[0];
        const asset = assetsData.find(a => a.id === id);
        downloadQR(id, asset.qr_code);
    } else {
        // Multiple QR codes - create combined image
        createCombinedQRImage(selectedAssets);
    }
}

function printSelected() {
    if (selectedAssets.length === 0) return;

    if (selectedAssets.length === 1) {
        // Single QR code print
        const id = selectedAssets[0];
        const asset = assetsData.find(a => a.id === id);
        printQR(id, asset.name, asset.qr_code);
    } else {
        // Multiple QR codes - print combined
        printCombinedQRs(selectedAssets);
    }
}

function createCombinedQRImage(assetIds) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const qrSize = 200;
    const padding = 20;
    const textHeight = 40;

    // Calculate grid dimensions
    const cols = Math.ceil(Math.sqrt(assetIds.length));
    const rows = Math.ceil(assetIds.length / cols);

    canvas.width = cols * (qrSize + padding) + padding;
    canvas.height = rows * (qrSize + textHeight + padding) + padding;

    // Fill background
    ctx.fillStyle = '#FFFFFF';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    assetIds.forEach((assetId, index) => {
        const row = Math.floor(index / cols);
        const col = index % cols;

        const x = col * (qrSize + padding) + padding;
        const y = row * (qrSize + textHeight + padding) + padding;

        // Get the QR canvas
        const qrCanvas = document.querySelector(`#qrcode-${assetId} canvas`);
        if (qrCanvas) {
            ctx.drawImage(qrCanvas, x, y, qrSize, qrSize);

            // Add asset name
            const asset = assetsData.find(a => a.id === assetId);
            ctx.fillStyle = '#000000';
            ctx.font = '14px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(asset.name, x + qrSize/2, y + qrSize + 25);
        }
    });

    // Download the combined image
    const link = document.createElement('a');
    link.download = `combined-qr-codes-${Date.now()}.png`;
    link.href = canvas.toDataURL();
    link.click();
}

function printCombinedQRs(assetIds) {
    const printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Combined QR Codes</title></head><body>');
    printWindow.document.write('<h1 style="text-align: center;">Combined QR Codes</h1>');
    printWindow.document.write('<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; padding: 20px;">');

    assetIds.forEach(assetId => {
        const canvas = document.querySelector(`#qrcode-${assetId} canvas`);
        const asset = assetsData.find(a => a.id === assetId);

        if (canvas && asset) {
            printWindow.document.write('<div style="text-align: center; border: 1px solid #ccc; padding: 10px;">');
            printWindow.document.write(`<h3>${asset.name}</h3>`);
            printWindow.document.write(`<p>${asset.location}</p>`);
            printWindow.document.write('<img src="' + canvas.toDataURL() + '" style="max-width: 200px;"/>');
            printWindow.document.write(`<p><small>QR: ${asset.qr_code}</small></p>`);
            printWindow.document.write('</div>');
        }
    });

    printWindow.document.write('</div></body></html>');
    printWindow.document.close();
    printWindow.print();
}

function downloadQR(id, code) {
    const canvas = document.querySelector(`#qrcode-${id} canvas`);
    if (canvas) {
        const link = document.createElement('a');
        link.download = `qr-code-${code}.png`;
        link.href = canvas.toDataURL();
        link.click();
    }
}

function printQR(id, label, code) {
    const canvas = document.querySelector(`#qrcode-${id} canvas`);
    if (canvas) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body style="text-align: center;">');
        printWindow.document.write(`<h2>${label}</h2>`);
        printWindow.document.write(`<p>QR Code: ${code}</p>`);
        printWindow.document.write('<img src="' + canvas.toDataURL() + '" style="max-width: 300px;"/>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
}

function createCombinedQR() {
    if (selectedAssets.length === 0) return;

    // Create a modal or form to input the label for combined QR
    const label = prompt('Enter a label for the combined QR code:', `Combined Assets (${selectedAssets.length} items)`);
    if (!label) return;

    // Create form data
    const formData = new FormData();
    formData.append('label', label);
    selectedAssets.forEach(id => {
        formData.append('asset_ids[]', id);
    });

    // Submit the form
    fetch('{{ route("dashboard.qr-codes.combined.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            alert('Combined QR code created successfully!');
            window.location.reload();
        } else {
            alert('Error creating combined QR code. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating combined QR code. Please try again.');
    });
}
</script>
@endsection
