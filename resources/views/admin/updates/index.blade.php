@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>Updates</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <div class="col-10">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="col-2">
            <a href="{{ route('admin.updates.create') }}" class="btn btn-block btn-outline-primary">Add Update Notice</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
    

                @php
                    $heads = ['ID', 'title', 'update For', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];

                    $config = [
                        'data' => $data,
                        'order' => [[1, 'asc']],
                        'columns' => [null, null, null, ['orderable' => false]],
                    ];
                @endphp

                {{-- Minimal example / fill data using the component slot --}}
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
