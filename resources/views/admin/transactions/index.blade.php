@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('plugins.Daterangepicker', true)

@section('content_header')
    <h3>Transaction Lists</h3>
@stop

@section('content')
    <div class="container-fluid text-capitalize">
        <div class="row">
            @if(session('message'))
            <div class="col-12">
                <x-adminlte-alert theme="success" title="Success">
                    {{ session('message') }}
                </x-adminlte-alert>
            </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <livewire:admin.transaction.transaction-list />
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
