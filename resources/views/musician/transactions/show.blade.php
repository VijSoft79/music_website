@extends('adminlte::page')

@section('title', 'Transaction Receipt')

@section('content_header')
    <div class="container">
        <h1 class="font-weight-bold">Transaction Receipt</h1>
    </div>
@stop

@section('content')
    <div class="container">

        <!-- Transaction Receipt Card -->
        <div class="card border border-success border-5 rounded">

            <!-- Receipt Header -->
            <div class="card-header bg-success text-white">
                <h3 class="card-title font-weight-bold">Receipt</h3>
                <p class="card-text">This statement serves as a receipt</p>
            </div>

            <!-- Transaction Amount Section -->
            <div class="card-body">
                <div class="row mb-3 py-3 ">
                    <div class="col-6 h4 font-weight-bold"  style="font-size:35px">Amount</div>
                    <div class="col-6 h4 font-weight-bold text-right" style="font-size:35px">${{ number_format($transaction->amount, 2) }}</div>
                </div>

                <!-- Transaction Details Section -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="font-weight-bold">Transaction Details</h4>
                    </div>
                    <div class="col-12">
                        <dl class="row">
                            <dt class="col-6">Type</dt>
                            <dd class="col-6 text-right">
                                @if ( $transaction->type === 'invitation-payment')
                                    Invitation payment
                                @else
                                    Music Payment
                                @endif
                            </dd>
                            <dt class="col-6">Date</dt>
                            <dd class="col-6 text-right">{{ \Carbon\Carbon::parse($transaction->created_at)->format('F d, Y') }}</dd>
                        </dl>
                    </div>
                </div>

                <!-- Conditional Invitation Details Section -->
                @if ($transaction->offer_id)
                    @php
                        $invitationTemplate = \App\Http\Controllers\CuratorWalletController::getTemplate($transaction->offer_id);
                    @endphp
                    <div class="row mb-3">  
                        <div class="col-12">
                            <h4 class="font-weight-bold">Invitation Details</h4>
                        </div>
                        <div class="col-12">
                            <dl class="row">
                                <dt class="col-6">Invitation Type</dt>
                                <dd class="col-6 text-right">{{ $invitationTemplate->name }}</dd>
                                <dt class="col-6">Invitation To</dt>
                                <dd class="col-6 text-right">{{ $transaction->invitation->music->artist->name }}</dd>
                                <dt class="col-6">Music</dt>
                                <dd class="col-6 text-right">{{ $transaction->invitation->music->title }}</dd>
                                <dt class="col-6">Date Of Completion</dt>
                                <dd class="col-6 text-right">{{ $transaction->invitation->date_complete }}</dd>
                            </dl>
                        </div>
                    </div>
                @endif

                <!-- Transaction Status Section -->
                <div class="row mb-3">
                    <div class="col-6 h4 font-weight-bold">Status</div>
                    <div class="col-6 h4 font-weight-bold text-right {{ $transaction->status == 'completed' ? 'text-success' : 'text-danger' }}">
                        {{ $transaction->status == 'completed' ? 'Completed' : 'Pending' }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop
