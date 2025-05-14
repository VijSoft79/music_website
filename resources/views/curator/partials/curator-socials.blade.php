<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="row">
            <div class="col-2">
                Curator Socials
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- facebook -->
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Facebook</label>
                    <div class="col-sm-10">
                        <input type="text" name="facebook_link" value="{{ Auth::user()->facebook_link }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- instagram --}}
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Instagram</label>
                    <div class="col-sm-10">
                        <input type="text" name="instagram_link" value="{{ Auth::user()->instagram_link }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- spotify --}}
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Spotify</label>
                    <div class="col-sm-10">
                        <input type="text" name="spotify_link" value="{{ Auth::user()->spotify_link }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- tiktok --}}
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Tiktok</label>
                    <div class="col-sm-10">
                        <input type="text" name="tiktok_link" value="{{ Auth::user()->tiktok_link }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- youtube --}}
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Youtube</label>
                    <div class="col-sm-10">
                        <input type="text" name="youtube_link" value="{{ Auth::user()->youtube_link }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- soundcloud --}}
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">SoundCloud</label>
                    <div class="col-sm-10">
                        <input type="text" name="soundcloud_link" value="{{ Auth::user()->soundcloud_link }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- songkick --}}
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">SongKick</label>
                    <div class="col-sm-10">
                        <input type="text" name="songkick_link" value="{{ Auth::user()->songkick_link }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- bandcamp --}}
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">BandCamp</label>
                    <div class="col-sm-10">
                        <input type="text" name="bandcamp_link" value="{{ Auth::user()->bandcamp_link }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- telegram --}}
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Telegram</label>
                    <div class="col-sm-10">
                        <input type="text" name="telegram" value="{{ Auth::user()->telegram }}" class="form-control"
                            id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- twitter --}}
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Twitter/X</label>
                    <div class="col-sm-10">
                        <input type="text" name="twitter_link" value="{{ Auth::user()->twitter_link }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

        </div>

    </div>
