<p>Dear {{ $musician->name }},</p>
@if ($template->offer_price)
    <p>This Message confirms that your Payment of {{ "$" . $template->offer_price }} has been recieved by
        {{ $curator->name }}
    </p>

    <p>The details of the payment are as follows:</p>

    <p><span>Selected Offer Type:</span> {{ $offer->offer_type }}</p>
    <p><span>Amount Paid:</span> ${{ $template->offer_price == null ? '0.00' : $template->offer_price }}</p>
    <pt><span>Date of Payment:</span> {{ $offer->updated_at }}</p>
        <p><span>Payment Method:</span> Bank Transfer</p>
        <p>Please acknowledge this message as a receipt of this payment and provide any necessary documentation or
            receipts
            for my records.
        <p>

        <p>Thank you for your cooperation and assistance. If you have any questions or require further information,
            please
            do not hesitate to contact Youhearus Team.</p>
    @else
        <p>This message confirms that sample musician accepted the invitation on 2025-02-10 16:52:59 for the agreed
            terms outlined in the invitation. </p>

        <p><span>Selected Offer Type:</span> {{ $offer->offer_type }}</p>
        <p> {{ $offer->offer_type == 'standard' ? '<span>Amount Paid:</span> $0.00' : ''}}</p>
        <p>Please proceed with the next steps as needed. If you require any further information, feel free to
            contact the Youhearus Team.</p>

        <p>Thank you for your cooperation.</p>


        <p>Best regards,</p>
        <p>Youhearus Team</p>
@endif
