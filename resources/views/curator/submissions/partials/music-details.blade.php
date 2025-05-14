<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Music Details
        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <dl>
                    <dt>Release Date</dt>
                    <dd>{{ date('M d, Y', strtotime($music->release_date)) }}</dd>

                    <dt>Genre</dt>
                    <dd>
                        @foreach ($music->genres as $genre)
                            {{ $genre->name }},
                        @endforeach
                    </dd>
                </dl>
            </div>
            <div class="col-md-6">
                <dl>
                    <dt>Release Type</dt>
                    <dd>{{ $music->release_type }}</dd>

                    <dt>Song version</dt>
                    <dd>{{ $music->song_version }}</dd>
                </dl>
            </div>
        </div>
        <dl>
            <dt>offer stats</dt>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td class="col-6">Invitation Received</td>
                        <td class="col-6">{{ $music->offers ? $music->offers->count() : 0 }}</td>
                    </tr>
                    <tr>
                        <td class="col-6">Accepted Invitations From You </td>
                        <td class="col-6">{{ Auth::user()->totalOffersToMusician($music->artist->id, 1) }}</td>
                    </tr>
                    <tr>
                        <td class="col-6">Pending Invitations From You </td>
                        <td class="col-6">{{ Auth::user()->totalOffersToMusician($music->artist->id, 0) }}</td>
                    </tr>
                </tbody>

            </table>

            <dt>description</dt>
            <dd>{!! $music->description !!}</dd>
        </dl>
    </div>
</div>