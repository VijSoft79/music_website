{{-- chosen offer get --}}
<div class="row">
    <div class="col">
        <div class="card-body p-2">
            <dl class="row">
                @if ($offer->offer_type == 'standard' || $offer->offer_type == 'basic-offer')
                    <dt class="col-6">Type:</dt>
                    <dd class="col-6">{{ $offer->offerTemplate->basicOffer->offer_type }}</dd>

                    <dt class="col-6">Price:</dt>
                    <dd class="col-6">{{ $offer->offerTemplate->basicOffer->offer_price }}</dd>

                    <dt class="col-6">description:</dt>
                    <dd class="col-6">{!! $offer->offerTemplate->basicOffer->description !!}</dd>
                @elseif ($offer->offer_type == 'free-option')
                    <dt class="col-6">Type:</dt>
                    <dd class="col-6">{{ $offer->offerTemplate->freeAlternative->type }}</dd>

                    <dt class="col-6">Url:</dt>
                    <dd class="col-6">{{ $offer->offerTemplate->freeAlternative->alter_url }}</dd>

                    <dt class="col-6">description:</dt>
                    <dd class="col-6">{!! $offer->offerTemplate->freeAlternative->alter_description !!}</dd>
                @elseif ($offer->offer_type == 'premium')
                    <dt class="col-6">Type:</dt>
                    <dd class="col-6">{{ $offer->offerTemplate->premiumOffer->offer_type }}</dd>

                    <dt class="col-6">Price:</dt>
                    <dd class="col-6">{{ $offer->offerTemplate->premiumOffer->offer_price }}</dd>

                    <dt class="col-6">description:</dt>
                    <dd class="col-6">{!! $offer->offerTemplate->premiumOffer->description !!}</dd>

                @elseif ($offer->offer_type == 'spotify-playlists' || $offer->offer_type == 'spotify-playlist')
                    <dt class="col-6">playlist:</dt>
                    <dd class="col-6">{{ $offer->offerTemplate->spotifyPlayList->playlist_name ?? 'no name' }}</dd>

                    <dt class="col-6">Song position:</dt>
                    <dd class="col-6">{{ $offer->offerTemplate->spotifyPlayList->song_position ?? 'no position' }}</dd>

                    <dt class="col-6">days to display:</dt>
                    <dd class="col-6">{{ $offer->offerTemplate->spotifyPlayList->days_of_display }}</dd>

                    <dt class="col-6">description:</dt>
                    <dd class="col-6">{!! $offer->offerTemplate->spotifyPlayList->description !!}</dd>
                @else
                    <p>No Selected offer</p>
                @endif
            </dl>
        </div>
    </div>
</div>
