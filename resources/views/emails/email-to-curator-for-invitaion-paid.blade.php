<p>Dear {{ $curator->name }},</p>
@if ($template->offer_price)
    <p>This message confirms that {{ $musician->name }} has accepted your Invitation and made a payment to you on
        {{ $offer->updated_at }}. The payment was made for the agreed terms outlined in the Invitation.</p>

    <p>The details of the payment are as follows:</p>

    <p><span>Selected Offer Type:</span> {{ $offer->offer_type }}</p>
    <p><span>Amount Paid:</span> ${{ $template->offer_price == null ? '0.00' : $template->offer_price }}</p>
    <p><span>Date of Payment:</span> {{ $offer->updated_at }}</p>
    <p><span>Payment Method:</span> Bank Transfer</p>

    <p>Please acknowledge receipt of this payment and provide any necessary documentation or receipts for my records.
    </p>

    <p>Thank you for your cooperation and assistance. If you have any questions or require further information, please
        do not hesitate to contact Youhearus Team.</p>
@else
    <p>This message confirms that sample musician has accepted your invitation on 2025-02-10 16:52:59 for the agreed
        terms outlined in the invitation. </p>

    <p><span>Selected Offer Type:</span> {{ $offer->offer_type }}</p>
    <p> {{ $offer->offer_type == 'standard' ? '<span>Amount Paid:</span> $0.00' : ''}}</p>
    <p>Please proceed with the next steps as needed. If you require any further information, feel free to
        contact the Youhearus Team.</p>

    <p>Thank you for your cooperation.</p>


    <p>Best regards,</p>
    <p>Youhearus Team</p>
@endif
