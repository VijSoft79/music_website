<div class="card card-primary card-outline direct-chat direct-chat-primary shadow-none">
    <div class="card-header">
        <h3 class="card-title">Invitation Details</h3>
    </div>
    <div class="card-body p-3">
        {{  $chosenInvitation->name }}<br>
        {{  $chosenInvitation->offer_price }}<br>
        {!!  $chosenInvitation->description !!}
    </div>
</div>