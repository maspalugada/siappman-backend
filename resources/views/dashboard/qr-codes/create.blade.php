@extends('layouts.app')

@section('title', 'Create QR Code - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <a href="{{ route('dashboard') }}" style="color: var(--primary-color); text-decoration: none; font-size: 1.125rem;">← Kembali ke Dasbor</a>
            <span style="color: var(--gray-400);">|</span>
            <a href="{{ route('dashboard.qr-codes') }}" style="color: var(--primary-color); text-decoration: none; font-size: 1.125rem;">Kembali ke Kode QR</a>
        </div>
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Buat Kode QR</h1>
        <p style="color: var(--gray-600);">Buat kode QR baru untuk konten Anda</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin: 0;">Detail Kode QR</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.qr-codes.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" placeholder="Masukkan nama kode QR" required>
                    @error('name')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="form-label">Tipe</label>
                    <select id="type" name="type" class="form-input" required>
                        <option value="">Pilih tipe</option>
                        <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Teks</option>
                        <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>URL</option>
                        <option value="phone" {{ old('type') == 'phone' ? 'selected' : '' }}>Telepon</option>
                        <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                    </select>
                    @error('type')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content" class="form-label">Konten</label>
                    <textarea id="content" name="content" class="form-input" rows="4" placeholder="Masukkan konten Anda di sini" required>{{ old('content') }}</textarea>
                    @error('content')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Buat Kode QR</button>
                    <a href="{{ route('dashboard.qr-codes') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
