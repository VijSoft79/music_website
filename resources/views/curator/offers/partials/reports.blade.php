<div class="col-12">
    @php
        $urls = json_decode($offer->report->url, true);
        $images = json_decode($offer->report->images, true);
        $count = is_array($urls) ? count($urls) : 0;
    @endphp

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3>Report Details</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-6">Status:</dt>
                <dd class="col-6">
                    {!! $offer->report->status == 'pending-checking' ? '<span class="text-danger text-bold">Pending-Checking</span>' : '<span class="text-success text-bold">Completed</span>' !!}
                </dd>

                @if ($urls)
                    @if (is_array($urls))
                        @foreach ($urls as $index => $url)
                            <dt class="col-6">Url({{ $index + 1 }}):</dt>
                            <dd class="col-6"><a href="{{ $url }}">{{ $url }}</a></dd>
                        @endforeach
                    @endif
                @else
                    <p>no urls</p>
                @endif

                <dt class="col-6">images:</dt>
                @if ($images)
                    @foreach ($images as $image)
                        <dd class="col-6"><img src="{{ asset('storage/' . $image) }}" alt="Image" style="max-width: 20%;"></dd>
                    @endforeach
                @else
                    <p>no images</p>
                @endif

            </dl>
        </div>
    </div>
</div>
