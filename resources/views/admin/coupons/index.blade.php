@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>Create Coupon</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
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
                <div class="card">
                    <div class="card-body">


                        @php
                            $heads = [
                                'ID',
                                'Name',
                                'Code',
                                'Status',
                                'Expiry date',
                                'Discount (%)',
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
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{route('coupon.delete')}}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation"></i></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h2>Are you sure you want to delete this coupon?</h2>
                            <input type="hidden" name="deletedId" id="deletedId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).on('click', '.deleteButton', function () {
            // console.log('asdasdas');
            var deleteId = $(this).data('deletedid');
            $('#deletedId').val(deleteId);           
        });
    </script>
@endsection
