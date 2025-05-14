@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Invitation Templates</h1>
@stop

@section('plugins.Datatables', true)

@section('plugins.DatatablesPlugin', true)

@section('css')
    <style>
        .template-disabled {
            opacity: 0.75; /* Slightly increased opacity */
            background-color: #f8f9fa; /* Light gray background */
            color: #6c757d; /* Muted text color */
        }
        .template-disabled td:nth-child(2) { /* Target the Invitation Title column */
             text-decoration: line-through; /* Add strikethrough to title */
        }
        .template-disabled .btn:not(.text-info, .text-secondary, .text-success) { /* Allow show and toggle buttons */
             pointer-events: none; /* Make non-essential buttons visually non-interactive */
             /* opacity: 0.5; /* Optionally further dim non-essential buttons */
        }
        /* Ensure toggle/show button colors aren't overridden by general text color */
        .template-disabled .btn.text-secondary,
        .template-disabled .btn.text-success,
        .template-disabled .btn.text-info {
            color: inherit !important; 
        }

    </style>
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

                @if ($errors->has('message'))
                    <div class="alert alert-danger">
                        {{ $errors->first('message') }}
                    </div>
                @endif
            </div>
            <div class="col-2">
                <a href="{{ route('curator.offer.template.create') }}" class="btn btn-block btn-outline-primary">Add
                    Invitation Template</a>
            </div>
        </div>
        {{-- Setup data for datatables --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        @php
                            $heads = [
                                'ID',
                                'Invitation Title',
                                'Publication',
                                'Status',
                                'Has Secondary',
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
                                <tr class="{{ $row['is_disabled'] ? 'template-disabled' : '' }}">
                                    @foreach ($row['data'] as $cell)
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

    <!-- Modal -->
    <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('curator.offer.template.delete') }}" method="POST">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this offer template?</h4>
                    </div>
                    
                    @csrf
                    <input type="hidden" name="deleteId" id="valDel" >
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });

        document.querySelectorAll('[title="Delete"]').forEach(function(button) {
            button.addEventListener('click', function() {
                var offerid = this.getAttribute('data-offer-id');
                document.getElementById('valDel').value = offerid;

                console.log(offerid);      
            });

        });
        
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;

            input = document.getElementById("search-input");

            filter = input.value.toUpperCase();

            table = document.getElementById("sortable-table");

            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // $(document).ready(function(){
        //     $('#deleteBtn').on('click', function(e){
        //         e.preventDefault();
        //         confirm('Are You sure you want to delete this offer?');
        //     });
        // });
    </script>
@stop
