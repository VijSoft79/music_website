@extends('adminlte::page')
@section('title', 'music')

@section('plugins.Datatables', true)
 
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>{{ Auth::user()->name }} Music List</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @php
                    $heads = ['ID', 'Name', 'Date Release', 'Status', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];

                    $config = [
                        'data' => $data,
                        'order' => [[1, 'asc']],
                        'columns' => [null, null, null, ['orderable' => false]],
                    ];
                @endphp

                <x-adminlte-datatable id="table1" :heads="$heads">
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

@if (session('missing_music_data'))
    <div class="modal fade" id="missingDataModal" tabindex="-1" aria-labelledby="missingDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="missingDataModalLabel">Incomplete Music Data</h5>
                    <button type="button" class="btn btn" data-dismiss="modal" ><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <p>The following music submissions have missing required fields:</p>
                    <ul>
                        @foreach (session('missing_music_data') as $music)
                            <li>
                                <strong>{{ $music['title'] }}</strong>
                                <ul>
                                    @foreach ($music['missing_fields'] as $field)
                                        <li>{{ $field }}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var missingDataModal = new bootstrap.Modal(document.getElementById('missingDataModal'));
            missingDataModal.show();
        });
    </script>
@endif
    

@stop
