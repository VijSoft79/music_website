<div class="card" style="font-size:20px">
    <div class="card-header bg-light">
        <h4 class="my-0 font-weight-normal">Free Option</h4>
    </div>
    <div class="card-body text-center">
        <h2>$0.00</h2>
        <ul class="list-unstyled mt-3 mb-4">
            <li>{{ $template->spotifyPlayList->playlist_name }}</li>
            <li>{{ $template->spotifyPlayList->playlist_url }}</li>
            <li>{{ $template->spotifyPlayList->song_position }}</li>
            <li>{{ $template->spotifyPlayList->days_of_display }}</li>
            <li>{{ $template->spotifyPlayList->description }}</li>
        </ul>
        <form action="{{ route('musician.invitation.approve', $offer) }}" method="post">
            @csrf
            <input type="hidden" name="approve" value="approve">
            <input type="hidden" name="templateId" value="{{ $template->spotifyPlayList->id }}">
            <input type="hidden" name="offerType" value="spotify-playlist">
            <button type="submit" class="btn btn-lg btn-block btn-outline-primary">Choose</button>
        </form>
    </div>
</div>
