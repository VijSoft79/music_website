@extends('layouts.email-header')

@section('content')
    <p>hi {{ $reciever->name }}, you have unread messages from {{ $sender->name }}</p>
    <b></b>
    <p>Offer Details:</p>
    <p>Music Offer: {{ $offer->music->title ?? '(invitation has not been accepted)'}}</p>


    @if ($offer->offer_type != null)

        @if ($offer->offer_type == 'premium')
            <p>Offer Name: {{ $offer->offerTemplate->premiumOffer->name }}</p>
        @elseif ($offer->offer_type == 'free-alternative')
            <p>Offer Name: {{ $offer->offerTemplate->freeAlternative->type }}</p>
        @elseif ($offer->offer_type == 'spotify-playlist')
            <p>Offer Name: {{ $offer->offerTemplate->spotifyPlayList->playlist_name }}</p>
        @else
            <p>Offer Name: {{ $offer->offerTemplate->basicOffer->name }}</p>
        @endif
        <p>Offer Price: {{ $offer->price ?? 'free' }}</p>
    @endif

    @if ($reciever->hasRole('musician'))
        <p>Please go to youhearus.com or: <a href="{{ url('/dashboard/musician/invitations/' . $offer->id) }}">Click Here</a></p> 
    @else
        <p>Please go to youhearus.com or: <a href="{{ url('/dashboard/curator/offers/' . $offer->id) }}">Click Here</a></p>
    @endif

@endsection
