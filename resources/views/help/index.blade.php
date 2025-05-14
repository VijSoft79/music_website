@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <div class="container">
        <h1>Help</h1>
    </div> --}}

@stop

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-9 m-5">
                @if (session('message'))
                <div class="my-2">
                    <x-adminlte-alert theme="success" title="Success">
                        {{ session('message') }}
                    </x-adminlte-alert>
                </div>
            @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="font-weight-bold">Help</h3>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            @php
                                if (Auth::user()->hasRole('musician')) {
                                    $content = 3;
                                } else {
                                    $content = 4;
                                }

                                $helpContent = \App\Models\PageContent::all();
                                $help = $helpContent->where('id', $content)->first();
                            @endphp
                            <div>
                                <p></p>
                            </div>
                            @php
                                if (Auth::user()->hasRole('curator')) {
                                    $action = route('curator.help.send');
                                } else {
                                    $action = route('musician.help.send');
                                }
                            @endphp
                            {{-- @if($help)
                                <p>{!! $help->content !!} </p>
                            @endif --}}
                            
                            <form class="w-50" action="{{ $action }}" method="post">
                                @csrf
                                <div class="row">
                                    <x-adminlte-input name="name" label="Name" placeholder="Write your message..." fgroup-class="col-md-12"
                                        disable-feedback />
                                </div>
                                <div class="row">
                                    <x-adminlte-input type="email" name="email" label="Email" placeholder="Write your message..."
                                        fgroup-class="col-md-12" disable-feedback />
                                </div>
                                <x-adminlte-textarea label="Message" name="question" placeholder="Insert description..." />

                                <x-adminlte-button type="submit" label="Send" theme="success" icon="fa-regular fa-paper-plane" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
@stop
