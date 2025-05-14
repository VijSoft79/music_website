@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)


@section('content_header')
    <h1>Admin Dashboard</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <h3 class="mt-3">Musics</h3>
                {{-- row 1 --}}
                <x-triplesmall-card title1="{{ $musicCount[0] }}" icon1="fas fa-music" url1="{{ route('admin.music.index') }}"
                    title2="{{ $musicCount[1] }}" icon2="fas fa-music" url2="{{ route('admin.music.index') }}"
                    title3="{{ $musicCount[2] }}" icon3="fas fa-music" url3="{{ route('admin.music.index') }}" />

                <h3 class="mt-3">Invitation Templates</h3>
                {{-- row 2 --}}
                <x-triplesmall-card title1="{{ $offerTemplate->count() }}" icon1="fa-solid fa-window-maximize"
                    url1="{{ route('admin.templates.index') }}" title2="{{ $offerTemplate->where('status', 1)->count() }}"
                    icon2="fa-solid fa-window-maximize" url2="{{ route('admin.templates.index') }}"
                    title3="{{ $offerTemplate->where('status', 0)->count() }}" icon3="fa-solid fa-window-maximize"
                    url3="{{ route('admin.templates.index') }}" />

                <h3 class="mt-3">Curator</h3>
                {{-- row 3 --}}
                <x-triplesmall-card title1="{{ $totalCurator[0] }}" icon1="fas fa-user-tie"
                    url1="{{ route('admin.curators.index') }}" title2="{{ $totalCurator[1] }}" icon2="fas fa-user-tie"
                    url2="{{ route('admin.curators.index') }}" title3="{{ $totalCurator[2] }}" icon3="fas fa-user-tie"
                    url3="{{ route('admin.curators.index') }}" />

                <h3 class="mt-3">Musician</h3>
                {{-- row 4 --}}
                <x-triplesmall-card title1="{{ $totalMusician[0] }}" icon1="fas fa-user"
                    url1="{{ route('admin.musicians.index') }}" title2="{{ $totalMusician[1] }}" icon2="fas fa-user"
                    url2="{{ route('admin.musicians.index') }}" title3="{{ $totalMusician[2] }}" icon3="fas fa-user"
                    url3="{{ route('admin.musicians.index') }}" />

                <h3 class="mt-3">Withdrawal</h3>
                {{-- row 5 --}}
                <x-triplesmall-card title1="{{ $transactions->count() }}" icon1="fa-solid fa-repeat"
                    url1="{{ route('widthrawal.index') }}"
                    title2="{{ $transactions->where('status', 'completed')->count() }}" icon2="fa-solid fa-repeat"
                    url2="{{ route('widthrawal.index') }}"
                    title3="{{ $transactions->where('status', 'pending')->count() + $transactions->whereNull('status')->count() }}"
                    icon3="fa-solid fa-repeat" url3="{{ route('widthrawal.index') }}" />
                <h3 class="mt-3">Invitations</h3>
                {{-- row 6 --}}
                <x-triplesmall-card title1="{{ $offerReports->count() }}" icon1="fa-solid fa-handshake"
                    url1="{{ route('admin.invitation.reports') }}"
                    title2="{{ $offerReports->where('status', 'completed')->count() }}" icon2="fa-solid fa-handshake"
                    url2="{{ route('admin.invitation.reports') }}"
                    title3="{{ $offerReports->where('status', 'pending checking')->count() }}"
                    icon3="fa-solid fa-handshake" url3="{{ route('admin.invitation.reports') }}" />
            </div>
        </div>
    </div>

    {{-- song price --}}
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        @php
                            $price = App\Models\Price::first();
                        @endphp
                        <form id="priceForm" action="{{ route('admin.price') }}" method="POST">
                            @csrf
                            {{-- With append slot, number type, and sm size --}}
                            <x-adminlte-input name="song_price" label="Song Price"
                                value="{{ old('song_price', $price->amount ?? 0) }}" placeholder="Enter price"
                                type="number" igroup-size="sm" min="1">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-dark">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>

                            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success"
                                icon="fas fa-lg fa-save" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- pending approval --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pending Approval</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- table --}}
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Music Title</th>
                                    <th>Date Published</th>
                                    <th>Status</th>
                                    <th>Artist Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($musics as $item)
                                    @if ($item->status == 0)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                <a href="{{ route('admin.music.show', $item->id) }}">
                                                    {{ $item->title }}
                                                </a>
                                            </td>
                                            <td>{{ $item->release_date }}</td>
                                            <td>
                                                <span class="badge bg-danger">pending</span>
                                            </td>
                                            <td>{{ $item->artist->name }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex justify-content-start">
                                    <h4>Curator Money Owed</h4>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-end flex-column">
                                    {{-- {{ number_format($inprogressTotalPendingAmount * 2, 2) }} --}}
                                    <h4 class="text-bold">Total In-Progress: ${{ number_format($totalInprogress * 2, 2) }}</h4>
                                    <h4 class="text-bold">Total Completed(Unapproved): ${{ number_format($totalCompleted * 2, 2) }}</h4>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="card-body">
                        @php
                            $heads = ['ID', 'Curator', 'Amount'];
                            $config = [
                                'data' => $data,
                                'order' => [[1, 'desc']],
                                'columns' => [null, null, null, ['orderable' => false]],
                            ];
                        @endphp

                        <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
                            @foreach ($config['data'] as $row)
                                <tr>
                                    @foreach ($row as $cell)
                                        <td>{!! $cell !!}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $("#priceForm").submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'), // Use the form's action URL
                    data: formData,
                    success: function(response) {
                        // Handle the success response
                        alert(response.message); // Display the success message
                        window.location.reload();

                        // Optionally, you can update the UI or redirect the user
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error('Form submission error:', error);

                        // Optionally, you can display an error message to the user
                    }
                });
            });
        });
    </script>

@stop
