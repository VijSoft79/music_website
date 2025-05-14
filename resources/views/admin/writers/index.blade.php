@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>Writers</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 my-2">
                <a class="btn btn-primary" href="{{route('admin.writers.create')}}">Add writer</a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $heads = ['ID', 'Name', 'Email', 'Contact', 'Status', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];
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
