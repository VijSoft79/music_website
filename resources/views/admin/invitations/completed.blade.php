@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h3 class="ml-2">Completed Invitations</h3>
@stop

@section('content')
    <div class="container-fluid text-capitalize">
        <div class="row">
            @if (session('message'))
                <div class="col-12">
                    <x-adminlte-alert theme="success" title="Success">
                        {{ session('message') }}
                    </x-adminlte-alert>
                </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">

                        @php
                            $heads = [
                                'ID',
                                'Music',
                                'Musician',
                                'Curator',
                                'Date Of Completion',
                                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                            ];
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
    </div>
@stop
