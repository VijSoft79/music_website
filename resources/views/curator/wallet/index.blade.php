@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>{{ ucfirst(Auth::user()->name) }} Wallet</h1>
@stop

@section('content')
    <div class="col-10">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                {{-- <a class="btn btn-block btn-outline-primary" href="{{ route('withdraw.payment.method') }}">Request Payout</a> --}}
                <x-adminlte-button label="Request Payout" data-toggle="modal" data-target="#modalCustom" class="bg-teal" />
            </div>
            @include('curator.wallet.partials.total-amount')
            @include('curator.wallet.partials.transactions-list-table')
        </div>
    </div>

    <x-adminlte-modal id="modalCustom" title="Payout Request Form" size="md" theme="teal" icon="fas fa-bell"
        v-centered static-backdrop scrollable>
        <div style="height:300px;">
            <p class="h4 font-weight-bold">Note:</p>
            <p>Your payment will be sent to you through Paypal. Please input your PayPal address below</p>
            <form action="{{ route('withdraw.request') }}" id="request-form" method="post">
                @csrf
                <x-adminlte-input label="Paypal address" name="email" type="email" placeholder="mail@example.com"
                    value="{{ Auth::user()->paypal ? Auth::user()->paypal->paypal_adress : Auth::user()->email }}" />
                <!-- Placeholder for displaying the wallet balance and message -->
                <p id="wallet-balance" class="mt-3">Loading wallet balance...</p>
                <!-- Additional message for insufficient balance -->
                <p id="balance-message" class="text-danger mt-2" style="display: none;">Your balance is below $5.</p>
            </form>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" class="mr-auto" label="Dismiss" data-dismiss="modal" />
            <x-adminlte-button type="submit" form="request-form" id="submit-button" class="ml-auto" theme="success"
                label="Accept" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('js')
    <script>
        $(document).ready(function() {

            // Fetch wallet balance when the modal is opened
            $('#modalCustom').on('show.bs.modal', function() {
                $.ajax({
                    url: "{{ route('wallet.check') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var balance = parseFloat(data.amount).toFixed(2);

                        // Display the wallet balance
                        if (isNaN(balance) || balance <= 0) {
                            // Handle case where balance is null, undefined, or 0
                            $('#wallet-balance').text('Wallet Balance: Not Available');
                            $('#submit-button').prop('disabled', true);
                            $('#balance-message').show().text(
                            'Your balance is not sufficient.');
                        } else {
                            $('#wallet-balance').text('Wallet Balance: $' + balance);

                            // Check if balance is less than $50
                            if (balance < 5) {
                                // Disable the submit button and show warning message
                                $('#submit-button').prop('disabled', true);
                                $('#balance-message').show().text('Your balance is below $50.');
                            } else {
                                // Enable the submit button if balance is $50 or more
                                $('#submit-button').prop('disabled', false);
                                $('#balance-message').hide(); // Hide the balance message
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Failed to fetch wallet data: ", error);
                        $('#wallet-balance').text('Error fetching wallet balance.');
                        $('#submit-button').prop('disabled', true);
                        $('#balance-message')
                    .hide(); // Hide the balance message in case of error
                    }
                });
            });
        });
    </script>
@stop
