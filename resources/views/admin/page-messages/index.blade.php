@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>Page Contents</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <x-adminlte-button label="Create message" data-toggle="modal" data-target="#modalPurple" class="bg-teal mb-2" />
                <div class="card">
                    <div class="card-body table-responsive">
                        @php
                            $heads = ['ID', 'Name', 'Content', 'Page', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];
                        @endphp
                        <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
                            @foreach ($data as $row)
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

    <x-adminlte-modal id="modalPurple" title="Theme Purple" theme="purple" icon="fas fa-bolt" size='lg' disable-animations>
        <form action="{{ route('page.messages.save') }}" method="post" id="messageCreate">
            @csrf
            <x-adminlte-input label="name" name="name" />

            <x-adminlte-input label="page" name="page" />

            <x-adminlte-textarea name="content" label="Description" rows=5 label-class="text-warning" igroup-size="sm" placeholder="Insert description...">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-dark">
                        <i class="fas fa-lg fa-file-alt text-warning"></i>
                    </div>
                </x-slot>
            </x-adminlte-textarea>

            <x-adminlte-button class="btn-flat" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save" />
        </form>
    </x-adminlte-modal>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#messageCreate').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    url: $(this).attr('action'), // The action URL from the form
                    method: $(this).attr('method'), // The method from the form
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        alert(response.message);
                        $('#modalPurple').modal('hide'); // Hide the modal
                        location.reload();
                    },
                    error: function(xhr) {
                        // Handle error response
                        alert('Error saving form!');
                    }
                });
            });

        });
    </script>
@stop
