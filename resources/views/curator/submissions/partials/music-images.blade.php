<div class="card card-outline card-primary">
    <div class="card-header">
        <h3>Images</h3>
    </div>
    <div class="card-body">
        {{-- additional images --}}


        <p>Note: click the image to download</p>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ asset($music->image_url) }}" download>
                    <img class="w-100" src="{{ asset($music->image_url) }}" alt="">
                </a>
            </div>
            {{-- Add Musician Profile Picture --}}
            @if (!empty($music->artist->profile_image_url))
                <div class="col-md-4">
                    <p class="text-center font-weight-bold">Artist Profile Picture</p>
                    <a href="{{ $music->artist->profile_image_url }}" download>
                        <img class="w-100" src="{{ $music->artist->profile_image_url }}" alt="Artist Profile Picture">
                    </a>
                </div>
            @endif
            {{-- End Musician Profile Picture --}}
            @if ($music->images()->count())
                @foreach ($music->images() as $image)
                    <div class="col-md-4">
                        <a href="{{ asset($image->image_path) }}" download>
                            <img class="w-100" src="{{ asset($image->image_path) }}" alt="">
                        </a>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
</div>
