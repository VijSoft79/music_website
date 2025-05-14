@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('title', 'Dashboard')

@section('content_header')
    <h1>Transaction list</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @php
                        $heads = ['ID', 'Type', 'Transaction Date', 'Status', 'Amount', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];
    
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
@stop
