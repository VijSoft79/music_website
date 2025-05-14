@extends('layouts.app')

@section('title', '404 Not Found')

@section('content_header')
    <h1 class="text-danger">404 - Page Not Found</h1>
@stop

@section('content')
<div class="error-page">
    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Page not found.</h3>
        <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="/home">return to dashboard</a>.
        </p>
    </div>
</div>
@stop

@section('css')
    <style>
        .error-page {
            margin: 20px auto 0;
            width: 600px;
            text-align: center;
        }
        .error-content {
            display: inline-block;
            padding: 20px;
            margin-top: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
@stop
