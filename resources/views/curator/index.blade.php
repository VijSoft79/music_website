@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ ucfirst(Auth::user()->name) }}</h1>
@stop

@section('content')

    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif(session('message'))
            <div class="alert alert-success">
                {!! session('message') !!}
            </div>
        @endif
        <div class="row">
            @if (Auth::user()->is_approve == 1)
                @if (Auth::user()->OfferTemplate->count() == 0)
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible">
                            <h3><i class="fa-solid fa-circle-check"></i> Approved!</h3>
                            <p>Hello <b>{{ ucfirst(Auth::user()->name) }}</b> Your profile has been approved and you are one
                                step closer to checking out all of the newest tunes submitted to You Hear Us. However,
                                in order to get you fully setup we need you to let the musicians know what you can offer
                                them as promotions and exposure.
                                Visit the "Add Invitation" link in the navigation pan1el or <b><a
                                    href="{{ route('curator.offer.template.create') }}">CLICK HERE!</a> </b>to create
                                your offers that you can send to musicians you would like to offer coverage.</p>
                        </div>
                    </div>
                @else
                    @if (Auth::user()->OfferTemplate()->where('status', 1)->first())
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible">
                                <p>Hello {{ Auth::user()->name }} please visit the <a
                                        href="{{ route('curator.submissions.index') }}">Artist Submission</a> to check out
                                    the latest tunes submitted by our musicians.</p>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible">
                                <p>Thank you for submitting your invitation template. Once our admin approves it you will be
                                    ready to view all of the current song submission by our musicians</p>
                            </div>
                        </div>
                    @endif
                @endif
            @else
                @if (Auth::user()->location && Auth::user()->phone_number && Auth::user()->bio)
                    <div class="alert alert-success">
                        Thank you for completing your profile. Our admins will check it over and once you are approved you
                        will be ready to fill out your offers to musicians. Please keep an eye on your email or here on your
                        curator dashboard for approval
                    </div>
                @else
                    <div class="container-fluid">
                        <div class="alert alert-warning alert-dismissible">
                            <h5>
                                <i class="icon fas fa-exclamation-triangle"></i> Pending Approval!
                            </h5>
                            Hi there {{ ucfirst(Auth::user()->name) }}. Thanks for registering. Please fill out your <a
                                href="{{ route('curator.show') }}" rel="nofollow">profile</a> in order to be approved
                        </div>
                    </div>
                @endif

            @endif

        </div>

        <h3 class="mb-2"><b>How to</b></h3>
        <div class="row justify-content-center">
            <!-- Step 1 -->
            <div class="col-md-6 d-flex justify-content-center mb-5 flex-column align-items-center">
                <p class="h5 mb-3"><b>"Curator Step 01 // Registration and Profile"</b></p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/8RYBVozgmSQ?si=yjJTxdjxrAXrVCfG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        
            <!-- Step 2 -->
            <div class="col-md-6 d-flex justify-content-center mb-5 flex-column align-items-center">
                <p class="h5 mb-3"><b>"Curator Step 02 // Invitations"</b></p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/hYGnZdA3Bg8?si=mAHUx3E5XJfIp9Ez" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        
            <!-- Step 3 -->
            <div class="col-md-6 d-flex justify-content-center flex-column align-items-center mb-5">
                <p class="h5 mb-3"><b>"Curator Step 03 // Finding Music and Sending Invitations"</b></p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/H5AfTTn4opg?si=NwTbsNb8R1jnZ5Mk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        
            <!-- Step 4 -->
            <div class="col-md-6 d-flex justify-content-center flex-column align-items-center mb-5">
                <p class="h5 mb-3"><b>"Curator Step 04 // Completing Invitations"</b></p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/AEGVsn3MLq0?si=YHjtJ556p0vTnBTQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>


@stop
