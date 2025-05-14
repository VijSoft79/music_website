<div class="col-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3>Other Images</h3>
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

</div>
