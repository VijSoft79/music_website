@extends('layouts.email-header')
@section('content')
    <div class="container">
        <!-- Email Content -->
        <div class="content" style="background-color: #1e293b; color: white;">
            {{-- <p style="font-size: 25px; font-weight: bold;">Dear [musician name],</p> --}}
            <p>You have received a new invitation from {{ $invitation->user->name ?? 'a curator' }}.</p>

            <p><strong>Invitation Details</strong></p>
            <ul>
                <li><strong>Invitation type:</strong> {{ $invitation->offerTemplate->basicOffer->offer_type }}</li>
                <li><strong>Invitation Amount:</strong> ${{ $invitation->offerTemplate->basicOffer->offer_price }}</li>
                <li><strong>Expected to Complete:</strong> {{ $invitation->date_complete }}</li>
            </ul>

            @if ($premiumTitle)
                <div id="premiumOffer">
                    <p><strong>Premium Invitation Details:</strong></p>
                    <ul>
                        <li><strong>Invitation type:</strong> {{ $invitation->offerTemplate->premiumOffer->offer_type }}</li>
                        <li><strong>Invitation Amount:</strong> ${{ $invitation->offerTemplate->premiumOffer->offer_price }}</li>
                        <li><strong>Expected to Complete:</strong> {{ $invitation->date_complete }}</li>
                    </ul>
                </div>
            @endif

            @if ($invitation->offerTemplate->freeAlternative)
                <p><strong>Free alternatives:</strong></p>
                <ul>
                    <li><strong>Invitation type:</strong> {{ $invitation->offerTemplate->freeAlternative->type }}</li>
                    <li><strong>Expected to Complete:</strong> {!! $invitation->offerTemplate->freeAlternative->alter_description !!}</li>
                </ul>
            @endif

            <p>Please review and process this request as soon as possible.</p>

            <a href="https://youhearus.com/dashboard/musician/invitations/{{ $invitation->id }}" class="button" style="color: black;">
                Review Request
            </a>

            <p>If you have any questions, please do not hesitate to contact us.</p>

        </div>

        <!-- Email Footer -->
        {{-- <div class="footer" style="background-color: #0f172a;">
            <p>&copy; 2024 You Hear Us. All rights reserved.</p>
        </div> --}}
    </div>
@endsection
