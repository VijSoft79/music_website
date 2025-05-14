@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.TempusDominusBs4', true)

@section('content_header')
    <h1>Create Coupon</h1>
@stop

@section('content')
    {{-- coupon name --}}
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('coupon.store') }}" method="post">
                            @csrf
                            {{-- <div class="row ml-1"> --}}
                                <x-adminlte-input name="name" label="Coupon Name" placeholder="Enter name" fgroup-class="col-md-auto"
                                    disable-feedback />
                            {{-- </div> --}}

                            {{-- <div class="row ml-1"> --}}
                                <x-adminlte-input name="coupon_code" id="coupon_code" label="Coupon Code" placeholder="Click Generate Code"
                                    fgroup-class="col-md-auto" disable-feedback />
                            {{-- </div> --}}

                            <x-adminlte-button label="Generate Code" id="generate_code" theme="primary" icon="fas fa-key" class="mb-5 ml-2" />

                            {{-- Placeholder, date only and append icon --}}
                            @php
                                $config = ['format' => 'L'];
                            @endphp
                            <x-adminlte-input-date  name="expire_date" :config="$config" placeholder="Choose an expiry date..."
                                fgroup-class="col-md-auto ">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-danger">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>

                            {{-- <div class="row ml-1"> --}}
                                <x-adminlte-input name="discount_amount" type="number" label="discount (%)" placeholder="Enter name"
                                    fgroup-class="col-md-auto" disable-feedback />
                            {{-- </div> --}}

                            <x-adminlte-button label="Save Coupon" type="submit" theme="success" class="mb-3 ml-2" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#generate_code').on('click', function() {
                $.ajax({
                    url: '/dashboard/generate-key',
                    type: 'GET',
                    success: function(response) {
                        $('#coupon_code').val(response.key);
                    },
                    error: function() {
                        alert('Error generating key');
                    }
                });
            });
        });
    </script>
@endsection
