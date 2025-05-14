@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>Blog Post</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            @if (session('message'))
                 <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
                <div class="card">

                    <div class="card-body">
                        @php
                            $heads = ['ID', 'Name', 'Status', 'Reminder Date', ['label' => 'Date Created', 'width' => 20], ['label' => 'Actions', 'no-export' => true, 'width' => 5]];

                            $config = [
                                'data' => $data,
                                'order' => [[1, 'asc']],
                                'columns' => [null, null, null, null, ['orderable' => false]],
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
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    function confirmDelete(event, deleteUrl) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this blog post?')) {
            window.location.href = deleteUrl;
        }
    }
</script>
@stop
