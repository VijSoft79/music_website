
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #1e293b;
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            color: #333333;
        }
        .content p {
            line-height: 1.6;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #eeeeee;
            color: #666666;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            font-size: 16px;
            color: #ffffff;
            background-color: #38bdf8;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #3ebef5;
            color:#eeeeee;
        }
    </style>
<div class="container">
    <!-- Email Content -->
    <div class="content" style="background-color: #1e293b; color: white;">
        {{-- <p style="font-size: 25px; font-weight: bold;">Dear [musician name],</p> --}}
        
        <p><strong>Invitation Details</strong></p>
        <ul>
            <li><strong>Invitation type:</strong> {{ $invitation->offerTemplate->basicOffer->offer_type }}</li>
            <li><strong>Invitation Amount:</strong> ${{ $invitation->offerTemplate->basicOffer->offer_price }}</li>
            <li><strong>Expected to Complete:</strong> {{ $invitation->date_complete }}</li>
        </ul>

        @if($premiumTitle)
            <div id="premiumOffer">
                <p><strong>Premium Invitation Details:</strong></p>
                <ul>
                    <li><strong>Invitation type:</strong> {{$invitation->offerTemplate->premiumOffer->offer_type}}</li>
                    <li><strong>Invitation Amount:</strong> ${{ $invitation->offerTemplate->premiumOffer->offer_price }}</li>
                    <li><strong>Expected to Complete:</strong> {{ $invitation->date_complete }}</li>
                </ul>
            </div>
        @endif
        
        @if($invitation->offerTemplate->freeAlternative)
        <p><strong>Free alternatives:</strong></p>
        <ul>
            <li><strong>Invitation type:</strong> {{ $invitation->offerTemplate->freeAlternative->type }}</li>
            <li><strong>Expected to Complete:</strong> {{ $invitation->offerTemplate->freeAlternative->alter_description }}</li>
        </ul>
        @endif

        <p>Please review and process this request as soon as possible.</p>

        <a href="https://youhearus.com/dashboard/musician/invitations/{{$invitation->id}}" class="button" style="color: black;">
            Review Request
        </a>
        
        <p>If you have any questions, please do not hesitate to contact us.</p>

    </div>
    
    <!-- Email Footer -->
    <div class="footer" style="background-color: #0f172a;">
        <p>&copy; 2024 You Hear Us. All rights reserved.</p>
    </div>
</div>

