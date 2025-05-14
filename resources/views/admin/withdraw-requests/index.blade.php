@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="ml-3">Withdrawal List</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            
            <div class="col-10">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="card-body">
                    @php
                        $heads = [
                            ['label' => 'Id', 'width' => 5], 
                            'Curator', 
                            'Status',
                            'Date Requested',
                            'Amount Requested', 
                            ['label' => 'Actions', 'no-export' => true, 'width' => 5]];

                        $config = [
                            'data' => $data,
                            'order' => [[1, 'asc']],
                            'columns' => [null, null, null, ['orderable' => true]],
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
@stop
