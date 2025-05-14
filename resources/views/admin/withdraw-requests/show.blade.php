@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <h1>{{ $request->user->name }} request</h1>
    </div>
@stop

@section('content')
    {{-- {{ $request }} --}}
    <div class="container">
        <div class="row border border-primary rounded py-3 px-5" style="border-width: 2px !important">
            <div class="col-12">
                <dl class="row" style="font-size: 20px">
                    <dt class="col-6">Transaction id:</dt>
                    <dd class="col-6 text-right"> {{ $request->id }}</dd>

                    <dt class="col-6">Date Requested:</dt>
                    <dd class="col-6 text-right"> {{ \Carbon\Carbon::parse($request->created_at)->format('F d, Y') }}</dd>

                    <dt class="col-6">Request Type:</dt>
                    <dd class="col-6 text-right">Withdrawal</dd>

                    <dt class="col-6">Paypal address:</dt>
                    <dd class="col-6 text-right">{{ $request->user->paypal->paypal_address }}</dd>

                    <dt class="col-6">Requested Amount:</dt>
                    <dd class="col-6 text-right font-weight-bold">${{ number_format($request->amount, 2) }}</dd>
                </dl>
            </div>

            <div class="col-12">
                @php
                    $transaction = $request;
                @endphp
                @if ($transaction->status != 'completed')
                    <form action="{{ route('widthrawal.update', $transaction) }}" method="post">
                        @csrf
                        <x-adminlte-button type="button" label="Approve Request" class="btn-lg" theme="outline-success" icon="fas fa-thumbs-up" data-toggle="modal" data-target="#exampleModal"/>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header bg-success">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                    </div>

                                    <div class="modal-body">
                                        <h2>
                                            Are you sure you want to approve this request?
                                        </h2>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>
                @endif
            </div>
        </div>

    </div>
@stop
