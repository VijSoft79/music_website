<x-adminlte-profile-widget name="{{ $music->title }}" desc="{{ $music->artist->name }}" class="profile-widget elevation-4 text-capitalize" img="{{ $music->artist->profile_image_url ?: asset('/images/default-image.jpg') }}" cover="{{ $music->image_url }}" layout-type="classic" header-class="text-right font-weight-bold" footer-class="bg-gradient-dark">

    {{-- Song details --}}
    <x-adminlte-profile-col-item class="border-right text-light" title="Song Version" text="{{ $music->song_version }}" size=6 badge="lime" />
    <x-adminlte-profile-col-item class="text-light" title="Release Date" text="{{ date('M d, Y', strtotime($music->release_date)) }}" size=6 badge="danger" />

    {{-- Social media links --}}
    <x-adminlte-profile-row-item title="Contact me on:" class="text-center text-light border-bottom mb-2" />
    <div class="col-12">
        <div class="row justify-content-center">
            @if ($music->artist->instagram_link && filter_var($music->artist->instagram_link, FILTER_VALIDATE_URL))
                <a href="{{ $music->artist->instagram_link }}" target="_blank" class="col-4 d-flex justify-content-center">
                    <x-adminlte-profile-row-item icon="fab fa-fw fa-2x fa-instagram text-light" url="{{ $music->artist->instagram_link }}" size=4 />
                </a>
            @endif

            @if ($music->artist->facebook_link && filter_var($music->artist->facebook_link , FILTER_VALIDATE_URL))
                <a href="{{ $music->artist->facebook_link }}" target="_blank" class="col-4 d-flex justify-content-center">
                    <x-adminlte-profile-row-item icon="fab fa-fw fa-2x fa-facebook text-light" url="{{ $music->artist->facebook_link }}" size=4 />
                </a>
            @endif
            @if ($music->artist->twitter_link && filter_var($music->artist->twitter_link, FILTER_VALIDATE_URL))
                <a href="{{ $music->artist->twitter_link }}" target="_blank" class="col-4 d-flex justify-content-center">
                    <x-adminlte-profile-row-item icon="fab fa-fw fa-2x fa-twitter text-light" url="{{ $music->artist->twitter_link }}" size=4 />
                </a>
            @endif
        </div>
    </div>


</x-adminlte-profile-widget>
