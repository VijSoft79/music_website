@extends('layouts.email-header')

@section('content')
    <p>Dear Admin,</p>
    <p>{{ $curator->name }} edited his Offer template and requesting for re Approval</p>
@endsection

