@extends('adminlte::page')
@section('plugins.BootstrapSwitch', true)

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <h1>Settings</h1>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h4>Toggle the emails you want to recieve</h4>
                <form action="{{ route('curator.settings.save') }}" method="post">
                    @csrf
                    <x-adminlte-card theme="primary" theme-mode="outline">
                        @foreach ($emailMessages as $emailMessage)
                            @if ($emailMessage->email_type !== 'registration notif')
                                    {{-- <input class="form-check-input" value="{{ $emailMessage->id }}" type="checkbox" name="emails[]" id="flexSwitchCheckDefault">
                                    <p class="text-capitalize pl-2 align-middle" style="font-size: 20px"> {{ $emailMessage->title }} </p> --}}
                                <div class="form-check p-2">
                                    <input class="form-check-input" type="checkbox" value="{{ $emailMessage->id }}" name="emails[]" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ $emailMessage->title }}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                        
                    </x-adminlte-card>
                    <x-adminlte-button class="btn-flat" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save" />
                </form>
            </div>
        </div>
    </div>
@stop
