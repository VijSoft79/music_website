@push('css')
    <style>
        #pro img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
        }
        .section-header {
            margin: 20px 0;
            padding: 10px 15px;
            border-radius: 3px;
            width: 100%;
        }
        .late-header {
            background-color: #f8d7da;
            border-left: 5px solid #dc3545;
            color: #721c24;
        }
        .normal-header {
            background-color: #d1ecf1;
            border-left: 5px solid #17a2b8;
            color: #0c5460;
        }
    </style>
@endpush
<div>
    <div class="row">
        @php
            use Carbon\Carbon;
        @endphp
        
        @if ($status == 0)
            @if (count($offers))
                @foreach ($offers as $offer)
                    @if (!Carbon::parse($offer->expires_at)->isPast())
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <a href="{{ route('curator.offers.show', $offer) }}">
                                <x-adminlte-profile-widget id="pro" name="{{ $offer->music->title }}" url="#"
                                    desc="by: {{ $offer->music?->artist?->band_name ?? 'Unknown Artist' }}" theme="lightblue"
                                    img="{{ $offer->music->image_url ? $offer->music->image_url : asset('/images/default-image.jpg') }}"
                                    layout-type="classic">
                                    <x-adminlte-profile-row-item title="Release Date"
                                        text="{{ date('M d, Y', strtotime($offer->music->release_date)) }}"
                                        badge="teal" />
                                    <x-adminlte-profile-row-item title="Date Sent"
                                        text="{{ date('M d, Y', strtotime($offer->created_at)) }}" badge="teal" />
                                    <x-adminlte-profile-row-item title="Expire Date"
                                        text="{{ date('M d, Y', strtotime($offer->expires_at)) }}" badge="warning" />
                                    <!-- date expire -->

                                    <x-adminlte-profile-row-item title="Status" text="Pending" badge="danger" />
                                </x-adminlte-profile-widget>
                            </a>
                        </div>
                    @endif
                @endforeach
            @else
                <p>No Invitations sent.</p>
            @endif
        @elseif ($status == 1)            
            @if(count($lateOffers) > 0)
                <div class="col-12">
                    <div class="section-header late-header">
                        <h4 class="h2"><i class="fas fa-exclamation-circle mr-2"></i> Late ({{ count($lateOffers) }})</h4>
                        <p>These invitations have passed their finish date and require attention.</p>
                    </div>
                </div>
                
                @foreach($lateOffers as $offer)
                    <div class="col-sm-12 col-md-6 col-lg-3">
                        <a href="{{ route('curator.offers.show', $offer->id) }}">
                            <x-adminlte-profile-widget id="pro" name="{{ $offer->music->title }}" url="#"
                                desc="by: {{ $offer->music?->artist?->band_name  ?? 'Unknown Artist' }}" theme="lightblue"
                                img="{{ $offer->music->image_url ? $offer->music->image_url : asset('/images/default-image.jpg') }}"
                                layout-type="classic">
                                <x-adminlte-profile-row-item title="Finish Date"
                                    text="{{ Carbon::parse($offer->date_complete)->format('M d, Y') }}"
                                    badge="danger" />
                                <x-adminlte-profile-row-item title="Days Overdue"
                                    text="{{ Carbon::parse($offer->date_complete)->diffInDays(Carbon::now()) }}"
                                    badge="danger" />
                                <x-adminlte-profile-row-item title="Status" text="Late" badge="danger" />
                                <div class="d-flex align-items-center justify-content-between col-12 p-0 border-top pt-2">
                                    {{-- manual card info --}}
                                    <span>Invitation</span>
                                    <div>
                                        @if ($offer->offer_type == 'standard')
                                            {!! $offer->offerTemplate->basicOffer->offer_price == 0
                                                ? '<span class="badge bg-success">Free</span>'
                                                : '<span class="badge bg-danger">Paid</span>' !!}

                                            <span class="badge bg-primary ms-1">
                                                {{ ucfirst($offer->offerTemplate->basicOffer->offer_type) . ' (' . ucfirst($offer->offer_type) . ')' }}
                                            </span>
                                        @elseif ($offer->offer_type == 'premium')
                                            {!! $offer->offerTemplate->premiumOffer->offer_price == 0
                                                ? '<span class="badge bg-success">Free</span>'
                                                : '<span class="badge bg-danger">Paid</span>' !!}

                                            <span class="badge bg-primary ms-1">
                                                {{ ucfirst($offer->offerTemplate->premiumOffer->offer_type) . ' (' . ucfirst($offer->offer_type) . ')' }}
                                            </span>
                                        @elseif ($offer->offer_type == 'free-option')
                                            <span class="badge bg-success">Free</span>

                                            <span class="badge bg-primary ms-1">
                                                {{ ucfirst($offer->offerTemplate->freeAlternative->offer_type) . ' (' . ucfirst($offer->offer_type) . ')' }}
                                            </span>
                                        @elseif ($offer->offer_type == 'spotify-playlist')
                                            <span class="badge bg-success">Free</span>

                                            <span class="badge bg-primary ms-1">
                                                {{ ucfirst($offer->offerTemplate->spotifyPlayList->playlist_name) . ' (' . ucfirst($offer->offer_type) . ')' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </x-adminlte-profile-widget>
                        </a>
                    </div>
                @endforeach
            @endif

            @if(count($activeOffers) > 0)
                <div class="col-12">
                    <div class="section-header normal-header">
                        <h4 class="h2"><i class="fas fa-clock mr-2"></i> Upcoming ({{ count($activeOffers) }})</h4>
                    </div>
                </div>
                
                @foreach($activeOffers as $offer)
                    <div class="col-sm-12 col-md-6 col-lg-3">
                        <a href="{{ route('curator.offers.show', $offer->id) }}">
                            <x-adminlte-profile-widget id="pro" name="{{ $offer->music->title }}" url="#"
                                desc="by: {{ $offer->music?->artist?->band_name ?? 'Unknown Artist' }}" theme="lightblue"
                                img="{{ $offer->music->image_url ? $offer->music->image_url : asset('/images/default-image.jpg') }}"
                                layout-type="classic">
                                <x-adminlte-profile-row-item title="Finish Date"
                                    text="{{ Carbon::parse($offer->date_complete)->format('M d, Y') }}"
                                    badge="teal" />
                                <x-adminlte-profile-row-item title="Release Date"
                                    text="{{ Carbon::parse($offer->music->release_date)->format('M d, Y') }}"
                                    badge="teal" />
                                <x-adminlte-profile-row-item title="Date Accepted"
                                    text="{{ Carbon::parse($offer->accepted_at)->format('M d, Y') }}" badge="teal" />
                                <x-adminlte-profile-row-item title="Status" text="Approved" badge="warning" />
                                <div class="d-flex align-items-center justify-content-between col-12 p-0 border-top pt-2">
                                    {{-- manual card info --}}
                                    <span>Invitation</span>
                                    <div>
                                        @if ($offer->offer_type == 'standard')
                                            {!! $offer->offerTemplate->basicOffer->offer_price == 0
                                                ? '<span class="badge bg-success">Free</span>'
                                                : '<span class="badge bg-danger">Paid</span>' !!}

                                            <span class="badge bg-primary ms-1">
                                                {{ ucfirst($offer->offerTemplate->basicOffer->offer_type) . ' (' . ucfirst($offer->offer_type) . ')' }}
                                            </span>
                                        @elseif ($offer->offer_type == 'premium')
                                            {!! $offer->offerTemplate->premiumOffer->offer_price == 0
                                                ? '<span class="badge bg-success">Free</span>'
                                                : '<span class="badge bg-danger">Paid</span>' !!}

                                            <span class="badge bg-primary ms-1">
                                                {{ ucfirst($offer->offerTemplate->premiumOffer->offer_type) . ' (' . ucfirst($offer->offer_type) . ')' }}
                                            </span>
                                        @elseif ($offer->offer_type == 'free-option')
                                            <span class="badge bg-success">Free</span>

                                            <span class="badge bg-primary ms-1">
                                                {{ ucfirst($offer->offerTemplate->freeAlternative->offer_type) . ' (' . ucfirst($offer->offer_type) . ')' }}
                                            </span>
                                        @elseif ($offer->offer_type == 'spotify-playlist')
                                            <span class="badge bg-success">Free</span>

                                            <span class="badge bg-primary ms-1">
                                                {{ ucfirst($offer->offerTemplate->spotifyPlayList->playlist_name) . ' (' . ucfirst($offer->offer_type) . ')' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </x-adminlte-profile-widget>
                        </a>
                    </div>
                @endforeach
            @endif
            
            @if(count($lateOffers) == 0 && count($activeOffers) == 0)
                <div class="col-12">
                    <p>No Invitations in progress.</p>
                </div>
            @endif
        @elseif ($status == 2)
                @if (count($offers))
                    @foreach ($offers as $offer)
                        <div class="col-sm-12 col-md-6 col-lg-3">                       
                            <a href="{{ route('curator.offers.show', $offer->id) }}">
                                <x-adminlte-profile-widget id="pro" name="{{ $offer->music?->title ?? 'no title' }}" url="#"
                                    desc="by: {{ $offer->music?->artist?->band_name ?? 'Unknown Artist' }}" theme="lightblue"
                                    img="{{ $offer->music?->image_url ?? asset('/images/default-image.jpg') }}"
                                    layout-type="classic">

                                    <x-adminlte-profile-row-item title="Release Date"
                                        text="{{ $offer->music?->release_date ?? 'N/A' }}" badge="teal" />

                                    <x-adminlte-profile-row-item title="Status" text="complete" badge="success" />
                                </x-adminlte-profile-widget>
                            </a>
                        </div>
                    @endforeach

                    <x-pagination-links :items="$offers" />

                @else
                    No Invitations sent.
                @endif
        @else
        @endif
    </div>
</div>
