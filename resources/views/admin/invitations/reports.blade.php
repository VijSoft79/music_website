@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h3 class="ml-2">In progress Invitations</h3>
@stop

@section('content')
    <div class="container-fluid text-capitalize">
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    <div class="card-body table-responsive">
                        <form action="{{ route('admin.invitation.store') }}" method="post">
                            
                            @csrf
                            @php
                                $heads = [
                                    ['label' => new \Illuminate\Support\HtmlString('<input type="checkbox" id="selectAll" class="select-all">'), 'width' => 5, 'orderable'=> false],
                                    'ID',
                                    'Music',
                                    'Musician',
                                    'Curator',
                                    'Offer Id',
                                    'Date Of Completion',
                                    'Offer Price',
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
                                <div class="text-right">
                                    <button id="checkButton" class="btn btn-primary mb-2" type="submit" hidden>Approve</button>
                                </div>
                            </x-adminlte-datatable>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalCustom" title="Account Policy" size="lg" theme="teal" icon="fas fa-bell" v-centered static-backdrop scrollable>
        <div style="height:800px;">Read the account policies...</div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" />
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

@stop

@section('js')
    <script>
        const selectAll = document.getElementById('selectAll');
        const offers = document.querySelectorAll('[id^="offer"]');
        const btncheck = document.getElementById('checkButton');

        selectAll.addEventListener('change', function() {
            offers.forEach(offer => {
                offer.checked = selectAll.checked;
            });
            btncheck.hidden = !selectAll.checked;
        });

        offers.forEach(offer => {
            offer.addEventListener('click', function() {
                let anyChecked = Array.from(offers).some(checkbox => checkbox.checked);
                let allChecked = Array.from(offers).every(checkbox => checkbox.checked);
                
                selectAll.checked = allChecked;
                btncheck.hidden = !anyChecked;
            });
        });
    </script>
@stop
