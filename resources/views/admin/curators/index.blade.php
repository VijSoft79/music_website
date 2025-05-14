@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1 class="ml-2">Curator Lists</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- <div class="col-12"> --}}
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

                <div class="col-12  my-2 d-flex w-100 justify-content-end">
                    <a class="btn btn-success" href="{{ route('curators.download') }}"><i class="fas fa-file"></i> Download file</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    @php
                        $heads = ['ID', 'Name', 'Email', 'Contact', 'Date', 'Status', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];

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

@section('js')

    <script type="text/javascript">
        function confirm_delete(event) {
            if (!confirm('Are you sure you want to delete this Curator?')) {
                event.preventDefault();
            }
        }
    </script>

@stop
