@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Campaign</h1>
        <a href="{{ route('admin.campaigns.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Campaigns
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Campaign Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label for="name">Campaign Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $campaign->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Custom Slug <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $campaign->slug) }}" required>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Warning: Changing the slug will break any existing links using the old slug. <strong>Only letters, numbers, and hyphens are allowed.</strong> Spaces and special characters will be converted to hyphens.</small>
                </div>

                <div class="form-group">
                    <div class="card bg-light mb-3">
                        <div class="card-header">Tracking URL Preview</div>
                        <div class="card-body">
                            <h5 class="card-title">Your tracking URL will look like:</h5>
                            <p class="card-text">
                                <code id="urlPreview">{{ url('/musician-register?ref=') }}<span id="slugPreview">{{ $campaign->slug }}</span></code>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="card bg-light mb-3">
                        <div class="card-header">Campaign Statistics</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Total Visits:</strong> {{ $campaign->clicks }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Registrations:</strong> {{ $campaign->registrations }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Campaign</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slugInput = document.getElementById('slug');
        const slugPreview = document.getElementById('slugPreview');
        
        function sanitizeSlug(input) {
            // Replace spaces and special characters with hyphens, except for allowed characters
            return input.replace(/[^a-zA-Z0-9\-]/g, '-')
                        .replace(/-+/g, '-') // Replace multiple hyphens with a single hyphen
                        .replace(/^-+|-+$/g, ''); // Remove leading and trailing hyphens
        }
        
        function updateSlugPreview() {
            const rawSlug = slugInput.value.trim();
            const sanitizedSlug = sanitizeSlug(rawSlug);
            
            // If the sanitized value is different from the input value, update the input
            if (rawSlug !== sanitizedSlug) {
                slugInput.value = sanitizedSlug;
            }
            
            slugPreview.textContent = sanitizedSlug;
        }
        
        // Update on input
        slugInput.addEventListener('input', updateSlugPreview);
        
        // Run validation on blur to catch any manual changes
        slugInput.addEventListener('blur', function() {
            const rawSlug = this.value.trim();
            const sanitizedSlug = sanitizeSlug(rawSlug);
            this.value = sanitizedSlug;
            updateSlugPreview();
        });
    });
</script>
@endpush
@endsection 