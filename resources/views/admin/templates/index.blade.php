@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1 class="ml-2">Offer-Templates</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-body">
                            @php
                                $heads = [
                                    'ID',
                                    'Name',
                                    'Curator Name',
                                    'Status',
                                    // ['label' => 'Date Created', 'width' => 40],
                                    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                                ];

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
        </div>
    </div>
    <div class="modal fade" id="deleteModal" theme="danger" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{ route('admin.templates.delete') }}" method="post">
            @csrf

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="m-2">Do you want to delete this template?</h4>
                        <input type="hidden" name="idDel" id="del">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
@section('js')
    <script>
       document.addEventListener('click', (e) => {
            const target = e.target.closest('[data-target="#deleteModal"]');
            if (target) {
                var userId = target.getAttribute('data-del');
                console.log(userId);
                document.getElementById('del').value = userId;
            }
        });


    </script>

@stop
