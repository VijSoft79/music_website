<div class="row">
    <div class="card card-outline card-primary w-100">
        <div class="card-header">
            <div class="row">
                <div class="col-6">Invitation details</div>
                <div class="col-6 text-right">
                    <x-adminlte-button class="btn-sm" type="button" id="declineBtn" label="Decline Invitation" theme="outline-danger" icon="fas fa-lg fa-trash" />
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row ">
                <div class="col-12" id="basicoffers">
                    @if ($template->freeAlternative)
                        @include('musician.invitations.partials.free-altenative')
                    @elseif($template->spotifyPlayList)
                        @include('musician.invitations.partials.spotify-playlist')
                    @endif
                </div>
                <div class="col-12" id="basicoffers">
                    <x-musician.invitation.offer-card :offer="$offer" :template="$template->basicOffer" type="standard" />
                </div>
                @if ($template->premiumOffer)
                    <div class="col-12">
                        <x-musician.invitation.offer-card :offer="$offer" :template="$template->premiumOffer" type="premium" />
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
