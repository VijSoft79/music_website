<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Social Media</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <x-adminlte-input name="facebook_link" label="Facebook" placeholder="placeholder" value="{{ old('', $user->facebook_link) }}" fgroup-class="col-md-6"
                disable-feedback />

            <x-adminlte-input name="instagram_link" label="Instagram" placeholder="placeholder" value="{{ old('', $user->instagram_link) }}" fgroup-class="col-md-6"
                disable-feedback />

            <x-adminlte-input name="youtube_link" label="Youtube" placeholder="placeholder" value="{{ old('', $user->youtube_link) }}" fgroup-class="col-md-6"
                disable-feedback />

            <x-adminlte-input name="spotify_link" label="Spotify" placeholder="placeholder" value="{{ old('', $user->spotify_link) }}" fgroup-class="col-md-6"
                disable-feedback />

            <x-adminlte-input name="tiktok_link" label="Tiktok" placeholder="placeholder" value="{{ old('', $user->tiktok_link) }}" fgroup-class="col-md-6"
                disable-feedback />

            <x-adminlte-input name="soundcloud_link" label="Sound Cloud" placeholder="placeholder" value="{{ old('', $user->soundcloud_link) }}"
                fgroup-class="col-md-6" disable-feedback />

            <x-adminlte-input name="songkick_link" label="Song Kick" placeholder="placeholder" value="{{ old('', $user->songkick_link) }}" fgroup-class="col-md-6"
                disable-feedback />

            <x-adminlte-input name="bandcamp_link" label="Band Camp" placeholder="placeholder" value="{{ old('', $user->bandcamp_link) }}" fgroup-class="col-md-6"
                disable-feedback />

            <x-adminlte-input name="telegram" label="Telegram" placeholder="placeholder" value="{{ old('', $user->telegram) }}" fgroup-class="col-md-6"
                disable-feedback />

            <x-adminlte-input name="twitter_link" label="Twitter/X" placeholder="placeholder" value="{{ old('', $user->twitter_link) }}" fgroup-class="col-md-6"
                disable-feedback />

        </div>
    </div>

</div>
