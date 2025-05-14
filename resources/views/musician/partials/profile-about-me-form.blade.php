<div class="card card-primary">
    <div class="card-header">
        <div class="row">
            <div class="col-2">
                About Me
            </div>
            <div class="col-8"></div>
            <div class="col-2 text-end">
                Status: <b
                    class="{{ Auth::user()->is_approve == 1 ? 'text-success' : 'text-danger' }}">{{ Auth::user()->is_approve == 1 ? 'Approve' : 'Pending Approve' }}</b>
            </div>
        </div>

    </div>
    <div class="card-body">
        <div class="row">
            <!-- Name -->
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Publication</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control"
                            id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- email --}}
            <div class="col-12  col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control"
                            id="inputPassword">
                    </div>
                </div>
                @error('contact')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contact -->
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Contact</label>
                    <div class="col-sm-10">
                        <input type="text" name="contact"
                            value="{{ old('phone_number', Auth::user()->phone_number) }}" class="form-control"
                            id="inputPassword">
                    </div>
                </div>
                @error('contact')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>

            <!-- location -->
            <div class="col-12 col-md-6">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Location</label>
                    <div class="col-sm-10">
                        <input type="text" name="location" value="{{ old('location', Auth::user()->location) }}"
                            class="form-control" id="inputPassword">
                    </div>
                </div>
            </div>

            {{-- date Published --}}
            <div class="col-12 col-md-6 px-1">
                <label for="inputPassword" class="col-12 col-sm-6 col-form-label">Publication Established
                    Date</label>
                <input type="date" name="date_founded" class="form-control"
                    value="{{ Auth::user()->date_founded }}">
            </div>

            <div class="col-12 col-md-6 px-1">
                <label for="inputPassword" class="col-12 col-sm-6 col-form-label">Estimated Visitor on your
                    website</label>
                <select class="form-control" name="" id="">
                    <option value="">1-100</option>
                    <option value="">101-300</option>
                    <option value="">301-1000</option>
                    <option value="">1000+</option>
                </select>
            </div>

            {{-- website --}}
            <div class="col-12">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Website</label>
                    <div class="col-sm-12">
                        <input type="text" name="website" value="{{ Auth::user()->website }}" class="form-control"
                            id="inputPassword">
                    </div>
                </div>

            </div>

            

            <!-- location -->
            <div class="col-12">
                <label for="inputPassword" class=" col-form-label">How many total reviews, articles, new posts, etc do you post per week?</label>
                    <input type="Number" name="location" value="{{ old('location', Auth::user()->location) }}"
                        class="form-control" id="inputPassword">
            </div>

            {{-- curator bio --}}
            <div class="col-12">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Bio</label>
                    <div class="col-sm-12">
                        <textarea name="bio" class="form-control" rows="10" placeholder="Tell us about your publication">{{ Auth::user()->bio }}</textarea>
                    </div>
                </div>
                @error('bio')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            @if (Auth::user()->is_approve != 1)
                <div class="col-12">
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Message To Admin</label>
                        <div class="col-sm-12">
                            <textarea name="message_to_admin" class="form-control" placeholder="Send A message to admin for faster Approval">{{ Auth::user()->message_to_admin }}</textarea>
                        </div>
                    </div>
                </div>
            @endif

            </hr>

            <div class="col-12">
                <h3>Curator Socials</h3>
            </div>


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
                        <input type="text" name="songkick_link" value="{{ Auth::user()->ongkick_link }}"
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
                        <input type="text" name="telegram" value="{{ Auth::user()->telegram }}"
                            class="form-control" id="inputPassword">
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

            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
