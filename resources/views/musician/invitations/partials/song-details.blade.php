<x-adminlte-profile-widget name="{{ $music->title }}" desc="{{ $music->artist->name }}"
    class="elevation-4 text-capitalize" img="{{ $music->artist->profile_image_url }}"
    cover="{{ $music->image_url }}" layout-type="classic" header-class="text-right text-white font-weight-bold"
    footer-class="bg-gradient-dark">

    <x-adminlte-profile-col-item class="border-right text-light" icon="" title="Song Version" text="{{ $music->song_version }}" size=6 badge="lime" />
    <x-adminlte-profile-col-item class="text-light" icon="" title="Date To be Publish" text="{{ date('M d,Y', strtotime($music->release_date)) }}" size=6 badge="danger" />

</x-adminlte-profile-widget>

<div class="my-3">
    <h3>Song</h3>
    <div style="display:flex" id="embed-container">
        {!! $music->embeded_url !!}
    </div>
</div>

<div class="card card-primary card-outline direct-chat direct-chat-primary shadow-none">
    <div class="card-header">
        <h3>Invitation Info:</h3>
    </div>
    <div class="card-body p-2">
        <p>{!! $template->basicOffer->offer_type !!}</p>
        <p>{!! $template->basicOffer->description !!}</p>
    </div>
    
</div>