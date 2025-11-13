@extends('layouts.app')

@section('title', 'Edit Instrument Set - SiAPPMan')

@section('content')
<div class="container">
    <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 2rem;">Edit Instrument Set</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.instrument-sets.update', $instrumentSet) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">Set Name</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $instrumentSet->name) }}" required>
                    @error('name')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-input" rows="4">{{ old('description', $instrumentSet->description) }}</textarea>
                    @error('description')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Select Assets</label>
                    <div style="max-height: 300px; overflow-y: auto; border: 1px solid var(--gray-300); border-radius: 0.5rem; padding: 1rem;">
                        @php
                            $selectedAssets = old('assets', $instrumentSet->assets->pluck('id')->toArray());
                        @endphp
                        @foreach($assets as $asset)
                            <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                                <input type="checkbox" name="assets[]" id="asset_{{ $asset->id }}" value="{{ $asset->id }}"
                                       @if(in_array($asset->id, $selectedAssets)) checked @endif
                                       style="margin-right: 0.5rem;">
                                <label for="asset_{{ $asset->id }}">{{ $asset->name }} ({{ $asset->instrument_type }})</label>
                            </div>
                        @endforeach
                    </div>
                    @error('assets')
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                    <a href="{{ route('dashboard.instrument-sets.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Set</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
