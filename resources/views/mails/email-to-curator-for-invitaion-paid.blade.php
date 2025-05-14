<p>Dear {{$curator->name}},</p>

<p>This Message confirms that {{$musician->name}}, have made a payment to you, {{$musician->name}}, on {{$offer->updated_at}}. The payment was made for </p>

<p>The details of the payment are as follows:</p>

<p><span>Amount Paid:</span> {{ $template->offer_price }}</p>
<p><span>Date of Payment:</span> {{$offer->updated_at}}</p>
<p><span>Payment Method:</span> Bank Transfer</p>
<p>Please acknowledge receipt of this payment and provide any necessary documentation or receipts for my records.<p>

<p>Thank you for your cooperation and assistance. If you have any questions or require further information, please do not hesitate to contact Youhearus Team.</p>