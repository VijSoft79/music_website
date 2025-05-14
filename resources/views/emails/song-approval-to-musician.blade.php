@extends('layouts.email-header')

@section('content')
    <p>{!! $content !!}</p>
    <a href="http://youhearus.com/dashboard/musician/payments/form/?music={{$music->id}}" class="btn">Click here to Pay</a>
@endsection