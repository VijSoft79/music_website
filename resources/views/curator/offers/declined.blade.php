@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>Declined Invitations</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row my-2">
            <div class="col-10">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @else
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $heads = [
                                'ID',
                                'Music',
                                'Musician',
                                'Declined By',
                                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                            ];

                            $config = [
                                'data' => $data,
                                'order' => [[1, 'asc']],
                                'columns' => [null, null, null, null, ['orderable' => false]],
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

@endsection