@extends('layouts.email-header')

@section('content')
    
<h3>Dear {{$artist}},</h3>
    <br>
    <div style="margin-left: 20px; text-align: justify;">
        <p>We wanted to inform you that your song <b>"{{$musicTitle}}"</b> has reached its expiration date and will be removed from the curators' playlists.
            <br>
            <br>
            <br>Thank you for being part of our community. Please feel free to reach out if you have any questions or need assistance.
        </p>
    </div>
<br>
<p>Best regards,
<br><b> You Hear Us Team</b></p>
@endsection