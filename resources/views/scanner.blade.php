@extends('layouts.app')

@section('title', 'QR Scanner - SiAPPMan')

@section('content')
<div class="container">
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">QR Code Scanner</h1>
        <p style="color: var(--gray-600);">Scan QR codes to record activities</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 1.5rem;">
                <div id="scanner-container" style="width: 100%; max-width: 400px; aspect-ratio: 1; background: var(--gray-100); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                    <div id="qr-reader"></div>
                    <div id="scanner-placeholder" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: var(--gray-400);">
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📱</div>
                        <p>Camera access required</p>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                    <button id="start-scan" class="btn btn-primary">
                        <span id="scan-icon">▶️</span>
                        Start Scanning
                    </button>
                    <button id="stop-scan" class="btn btn-secondary" style="display: none;">
                        <span id="stop-icon">⏹️</span>
                        Stop Scanning
                    </button>
                </div>

                <div id="scan-result" style="width: 100%; max-width: 400px; text-align: center; display: none;">
                    <div class="alert alert-success" id="result-message"></div>
                </div>

                <div id="scan-form" style="width: 100%; max-width: 400px; display: none;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Record Scan Activity</h3>
                    <form id="activity-form">
                        <input type="hidden" id="scanned-qr-code" name="qr_code">

                        <div class="form-group">
                            <label for="action" class="form-label">Action</label>
                            <select id="action" name="action" required class="form-input">
                                <option value="">Select Action</option>
                                <option value="check-in">Check In</option>
                                <option value="check-out">Check Out</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="inspection">Inspection</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea id="notes" name="notes" rows="3" class="form-input"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" id="location" name="location" class="form-input">
                        </div>

                        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">Record Scan</button>
                            <button type="button" onclick="resetScanner()" class="btn btn-secondary" style="flex: 1;">Scan Another</button>
                        </div>
                    </form>
                </div>

                <div id="scan-history" style="width: 100%; max-width: 400px;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Recent Scans</h3>
                    <div id="recent-scans" style="space-y: 0.5rem;">
                        <p style="color: var(--gray-500); font-style: italic;">No recent scans</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="/js/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let html5QrcodeScanner;
    const placeholder = document.getElementById('scanner-placeholder');
    const startBtn = document.getElementById('start-scan');
    const stopBtn = document.getElementById('stop-scan');
    const resultDiv = document.getElementById('scan-result');
    const resultMessage = document.getElementById('result-message');
    const scanForm = document.getElementById('scan-form');
    const recentScans = document.getElementById('recent-scans');

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code matched = ${decodedText}`, decodedResult);
        showResult('QR Code detected: ' + decodedText, 'success');
        document.getElementById('scanned-qr-code').value = decodedText;
        scanForm.style.display = 'block';
        html5QrcodeScanner.clear().then(() => {
            console.log('Scanner stopped');
            placeholder.style.display = 'flex';
            startBtn.style.display = 'inline-flex';
            stopBtn.style.display = 'none';
        }).catch((err) => {
            console.log('Failed to stop scanner:', err);
        });
    }

    function onScanFailure(error) {
        console.warn(`Code scan error = ${error}`);
    }

    function startScanner() {
        placeholder.style.display = 'none';
        startBtn.style.display = 'none';
        stopBtn.style.display = 'inline-flex';

        html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }

    function stopScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().then(() => {
                console.log('Scanner stopped');
                placeholder.style.display = 'flex';
                startBtn.style.display = 'inline-flex';
                stopBtn.style.display = 'none';
            }).catch((err) => {
                console.log('Failed to stop scanner:', err);
            });
        }
    }

    function showResult(message, type) {
        resultMessage.textContent = message;
        resultDiv.className = 'alert alert-' + type;
        resultDiv.style.display = 'block';
    }

    function resetScanner() {
        scanForm.style.display = 'none';
        resultDiv.style.display = 'none';
        document.getElementById('activity-form').reset();
        startScanner();
    }

    startBtn.addEventListener('click', startScanner);
    stopBtn.addEventListener('click', stopScanner);

    document.getElementById('activity-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        fetch('/api/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                showResult(data.message, 'success');
                updateRecentScans(data.scan || data);
            } else {
                showResult('Error recording scan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showResult('Error recording scan', 'error');
        });
    });

    function updateRecentScans(scanData) {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        const scanItem = document.createElement('div');
        scanItem.style.cssText = 'padding: 0.75rem; background: var(--gray-50); border-radius: 0.5rem; margin-bottom: 0.5rem;';
        scanItem.innerHTML = `
            <div style="font-weight: 500; color: var(--gray-900);">${scanData.qr_code || 'Unknown'}</div>
            <div style="font-size: 0.875rem; color: var(--gray-500);">${timeString}</div>
            <div style="font-size: 0.875rem; color: var(--primary-color);">${scanData.action || 'Scanned'}</div>
        `;

        // Remove "No recent scans" message
        const noScansMsg = recentScans.querySelector('p');
        if (noScansMsg) {
            noScansMsg.remove();
        }

        // Add new scan to top
        recentScans.insertBefore(scanItem, recentScans.firstChild);

        // Keep only last 5 scans
        while (recentScans.children.length > 5) {
            recentScans.removeChild(recentScans.lastChild);
        }
    }

    // Initialize scanner
    startScanner();
});
</script>
@endpush
