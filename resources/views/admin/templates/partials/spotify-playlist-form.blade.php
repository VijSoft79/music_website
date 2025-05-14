<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Free Option</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <x-adminlte-input name="alterOffername" label="Invitation Type" value="{{ $OfferTemplate->spotifyPlaylist->playlist_name }}" placeholder="Alternative Invitation Type" fgroup-class="col-md-6" disable-feedback class="input" />

            <x-adminlte-input name="alterUrl" label="Invitation URL" value="{{ $OfferTemplate->spotifyPlaylist->playlist_url }}" placeholder="Alternative Invitation URL" fgroup-class="col-md-6" disable-feedback class="input" />

            <x-adminlte-input name="alterUrl" label="Song Position" value="{{ $OfferTemplate->spotifyPlaylist->song_position }}" placeholder="Alternative Invitation URL" fgroup-class="col-md-6" disable-feedback class="input" />

            <x-adminlte-input name="alterUrl" label="Days To be Display" value="{{ $OfferTemplate->spotifyPlaylist->days_of_display }}" placeholder="Alternative Invitation URL" fgroup-class="col-md-6" disable-feedback class="input" />

            <x-adminlte-textarea name="alterdescription" label="Description" placeholder="Description" rows="5" fgroup-class="col-md-12" class="input">
                {{ strip_tags($OfferTemplate->spotifyPlaylist->description) }}
            </x-adminlte-textarea>

        </div>
    </div>

</div>
