@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>Page Contents</h1>
@stop

@section('content')
    @php
        $heads = ['ID', 'Title', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];
        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
        ];
    @endphp
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-body">
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
@stop

