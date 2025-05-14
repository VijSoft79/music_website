<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Spotify Playlist</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <input name="type" type="hidden" value="spotify">
            <x-adminlte-input name="playlist_name" label="Invitation Type" value="{{ $OfferTemplate->spotifyPlaylist->playlist_name }}" placeholder="Alternative Invitation Type" fgroup-class="col-md-6" disable-feedback class="input" />

            <x-adminlte-input name="playlist_url" label="Invitation URL" value="{{ $OfferTemplate->spotifyPlaylist->playlist_url }}" placeholder="Alternative Invitation URL" fgroup-class="col-md-6" disable-feedback class="input" />

            <x-adminlte-input name="song_position" label="Song Position" value="{{ $OfferTemplate->spotifyPlaylist->song_position }}" placeholder="Alternative Invitation URL" fgroup-class="col-md-6" disable-feedback class="input" />

            <x-adminlte-input name="day_of_display" label="Days To be Display" value="{{ $OfferTemplate->spotifyPlaylist->days_of_display }}" placeholder="Alternative Invitation URL" fgroup-class="col-md-6" disable-feedback class="input" />

            <x-adminlte-textarea name="description" label="Description" placeholder="Description" rows="5" fgroup-class="col-md-12" class="input description">
                {{ $OfferTemplate->spotifyPlaylist->description }}
            </x-adminlte-textarea>

        </div>
    </div>

</div>
