<p>Dear {{$musician->name}},</p>

<p>This Message confirms that your Payment of {{ $template->offer_price }} has been recieved by {{$curator->name}}</p>

<p>The details of the payment are as follows:</p>

<p><span>Amount Paid:</span> {{ $template->offer_price }}</p>
<pt><span>Date of Payment:</span> {{$offer->updated_at}}</p>
<p><span>Payment Method:</span> Bank Transfer</p>
<p>Please acknowledge this message as a receipt of this payment and provide any necessary documentation or receipts for my records.<p>

<p>Thank you for your cooperation and assistance. If you have any questions or require further information, please do not hesitate to contact Youhearus Team.</p>