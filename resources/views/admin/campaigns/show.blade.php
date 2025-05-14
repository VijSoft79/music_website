@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Campaign Details</h1>
        <div>
            <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Campaign
            </a>
            <a href="{{ route('admin.campaigns.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Campaigns
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Campaign Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px;">Campaign ID</th>
                                <td>{{ $campaign->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $campaign->name }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ $campaign->slug }}</td>
                            </tr>
                            <tr>
                                <th>Created</th>
                                <td>{{ $campaign->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $campaign->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tracking Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Visits</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $campaign->clicks }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Registrations</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $campaign->registrations }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Conversion Rate
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        @if($campaign->clicks > 0)
                                                            {{ number_format(($campaign->registrations / $campaign->clicks) * 100, 2) }}%
                                                        @else
                                                            0%
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ $campaign->clicks > 0 ? ($campaign->registrations / $campaign->clicks) * 100 : 0 }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-percent fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tracking URL</h6>
        </div>
        <div class="card-body">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="trackingUrl" value="{{ url('/musician-register?ref=' . $campaign->slug) }}" readonly>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard()">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
            </div>
            <small class="text-muted">Share this URL with your ad partner to track visits and registrations from this campaign.</small>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard() {
        const copyText = document.getElementById("trackingUrl");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        document.execCommand("copy");
        
        alert("Tracking URL copied to clipboard!");
    }
</script>
@endpush
@endsection 