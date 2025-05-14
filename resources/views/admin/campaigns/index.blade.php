@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Ad Campaigns</h1>
        <a href="{{ route('admin.campaigns.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm m-3">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New Ad Campaign
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-secondary">Ad Campaigns</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Visits</th>
                            <th>Registrations</th>
                            <th>Conversion Rate</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->id }}</td>
                            <td>{{ $campaign->name }}</td>
                            <td>{{ $campaign->slug }}</td>
                            <td>{{ $campaign->clicks }}</td>
                            <td>{{ $campaign->registrations }}</td>
                            <td>
                                @if($campaign->clicks > 0)
                                    {{ number_format(($campaign->registrations / $campaign->clicks) * 100, 2) }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ $campaign->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this campaign?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 