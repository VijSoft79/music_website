@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <h1 class="font-weight-bold">{{$transaction->type }}</h1>
    </div>
@stop

@section('content')
    <div class="container">

        <!-- Transaction Receipt Container -->
        <div class="border border-success border-5 rounded p-4">
            <p class="text-danger">
                This statement serves as a receipt
            </p>
            
            <!-- Transaction Amount Section -->
            <div class="row border p-4 mb-3">
                <div class="col-6 h4 font-weight-bold">Amount</div>
                <div class="col-6 h4 font-weight-bold text-right">${{ number_format($transaction->amount, 2) }}</div>
            </div>

            <!-- Transaction Details Section -->
            <div class="row border p-4 mb-3">
                <div class="col-12">
                    <h4 class="h4 font-weight-bold">Transaction Details</h4>
                </div>
                <div class="col-12">
                    <dl class="row">
                        <dt class="col-6">Type</dt>
                        <dd class="col-6 text-right">{{ $transaction->type }}</dd>
                        <dt class="col-6">From</dt>
                        <dd class="col-6 text-right">Musician</dd>
                        <dt class="col-6">Date</dt>
                        <dd class="col-6 text-right">{{ \Carbon\Carbon::parse($transaction->created_at)->format('F d, Y') }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Conditional Invitation Details Section -->
            @if($transaction->invitation)
            @php
                $invitationTemplate = \App\Http\Controllers\CuratorWalletController::getTemplate($transaction->offer_id);
            @endphp
                <div class="row border p-4 mb-3">
                    <div class="col-12">
                        <h4 class="h4 font-weight-bold">Invitation Details</h4>
                    </div>
                    <div class="col-12">
                        <dl class="row">
                            <dt class="col-6">Invitation Type</dt>
                            <dd class="col-6 text-right">{{$invitationTemplate->name}}</dd>
                            <dt class="col-6">Invitation To</dt>
                            <dd class="col-6 text-right">{{$transaction->invitation->music->artist->name}}</dd>
                            <dt class="col-6">Music</dt>
                            <dd class="col-6 text-right">{{$transaction->invitation->music->title}}</dd>
                            <dt class="col-6">Date Of Completion</dt>
                            <dd class="col-6 text-right">December 24, 2044</dd>
                        </dl>
                    </div>
                </div>
            @endif

            <!-- Transaction Status Section -->
            <div class="row border p-4 mb-3">
                <div class="col-6 h4 font-weight-bold">Status</div>
                <div class="col-6 h4 font-weight-bold text-right {{ $transaction->status == 'completed' ? 'text-success' : 'text-danger' }}">
                    {{ $transaction->status == 'completed' ? 'Completed' : 'Pending' }}
                </div>
            </div>
        </div>
       
    </div>
@stop
