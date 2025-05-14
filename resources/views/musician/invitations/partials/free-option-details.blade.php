<div class="card card-primary card-outline direct-chat direct-chat-primary shadow-none">
    @if ($offer->offer_type == 'free-option')
        <div class="card-header">
            <h3 class="card-title fw-bold">Free Option</h3>
        </div>

        <div class="card-body p-3">
            <dl>
                <dt>Type</dt>
                <dd>{{ $chosenInvitation->type }}</dd>
                <dt>Description</dt>
                <dd>{!! $chosenInvitation->alter_description !!}</dd>
            </dl>
        </div>
    @else
        <div class="card-header">
            <h3 class="card-title fw-bold">Spotify Playlist</h3>
        </div>

        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-6"> 
                    <dl>
                        <dt>Play List Name</dt>
                        <dd>{{ $chosenInvitation->playlist_name }}</dd>
                        <dt>Description</dt>
                        <dd>{!! $chosenInvitation->description !!}</dd>
                    </dl>
                </div>
                <div class="col-md-6"> 
                    <dl>
                        <dt>Song Position</dt>
                        <dd>{{ $chosenInvitation->song_position }}</dd>
                        <dt>Days To Display</dt>
                        <dd>{{ $chosenInvitation->days_of_display }}</dd>
                        <dt>Play List Url</dt>
                        <dd><a href="{{ $chosenInvitation->playlist_url }}"> {{ $chosenInvitation->playlist_url }}</a></dd>
                    </dl>
                </div>
            </div>    
        </div>
    @endif
</div>
