@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row h-100 align-items-center justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card mx-auto" style="max-width: 800px;">
                <div class="card-header text-center">
                    <h2 class="mb-0" style="font-family: 'Inter', sans-serif; font-size: 2rem;">Email Preferences Updated</h2>
                </div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        You have been successfully unsubscribed from non-critical emails.
                    </div>
                    
                    <p class="mb-3">
                       You will no longer receive promotional and notification emails from us.
                    </p>

                    <p class="mb-3">
                        You will still receive critical emails like password resets and account security notifications.
                    </p>

                    <p class="mb-4">
                        If you'd like to resubscribe to our emails in the future, you can do so from your account settings.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 