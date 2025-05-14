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
                <form action="{{ route('page.messages.update', $pageMessage) }}" method="post" id="messageCreate">
                    @csrf
                    <x-adminlte-input label="name" name="name" value="{{ $pageMessage->name ? $pageMessage->name : old('name') }}" />
        
                    <x-adminlte-input label="page" name="page" value="{{old('name', $pageMessage->page)}}" />
        
                    <x-adminlte-textarea name="content" label="Description" rows=5 label-class="text-warning" igroup-size="sm" placeholder="Insert description...">
                        {{old('name', $pageMessage->content)}} 
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-lg fa-file-alt text-warning"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-textarea>
        
                    <x-adminlte-button class="btn-flat" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save" />
                </form>
            </div>
        </div>
    </div>
        
@stop
