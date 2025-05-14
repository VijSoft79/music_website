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
<div class="row">
    {{-- @dd($status) --}}
    @if ($status == 0)
        @if (count($offers))
            @foreach ($offers as $offer)
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <a href="{{ route('musician.invitation.show', $offer->id) }}">
                        <x-adminlte-profile-widget id="pro" name="{{ $offer->music->title }}" url="#"
                            desc="Offered by: {{ $offer->user->name }}" theme="lightblue"
                            img="{{ $offer->user->profile_image_url ? $offer->user->profile_image_url : asset('/images/default-image.jpg') }}"
                            layout-type="classic">
                            {{-- <x-adminlte-profile-widget name="{{ $offer->music->title }}" url="#" desc="Invited by: {{ $offer->user->name }}" img="{{ asset($offer->user->profile_image_url) }}" layout-type="classic" style="background: url('{{ asset($offer->music->image_url) }}'); background-size: cover; background-repeat: no-repeat; background-position: center;"> --}}
                            <x-adminlte-profile-row-item title="Release Date"
                                text="{{ date('M d, Y', strtotime($offer->music->release_date)) }}" badge="teal" />
                            <x-adminlte-profile-row-item title="Expiration Date"
                                text="{{ date('M d, Y', strtotime($offer->expires_at)) }}" badge="teal" />
                            <x-adminlte-profile-row-item title="Status"
                                text="{{ $offer->status == 0 ? 'Pending' : 'Approved' }}"
                                badge="{{ $offer->status == 0 ? 'danger' : 'lightblue' }}" />
                        </x-adminlte-profile-widget>
                    </a>
                </div>
            @endforeach
        @else
            No Pending Invitations.
        @endif
    @elseif ($status == 1)
        @if (count($offers))
            @foreach ($offers as $offer)
                @php
                    $completedAt = \Carbon\Carbon::parse($offer->date_complete);
                    if ($completedAt->isBefore(\Carbon\Carbon::now())) {
                        $theme = 'danger';
                    } else {
                        $theme = 'teal';
                    }
                @endphp
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <a href="{{ route('musician.invitation.show', $offer->id) }}">
                        <x-adminlte-profile-widget id="pro" name="{{ $offer->music->title }}" url="#"
                            desc="Offered by: {{ $offer->user->name }}" theme="lightblue"
                            img="{{ asset($offer->user->profile_image_url) }}" layout-type="classic">
                            <x-adminlte-profile-row-item title="Release Date"
                                text="{{ date('M d, Y', strtotime($offer->music->release_date)) }}" badge="teal" />
                            <x-adminlte-profile-row-item title="Finish Date"
                                text="{{ date('M d, Y', strtotime($offer->date_complete)) }}"
                                badge="{{ $theme }}" />
                            <x-adminlte-profile-row-item title="Status"
                                text="{{ $offer->status == 1 ? 'Approved' : 'Approved' }}"
                                badge="{{ $offer->status == 1 ? 'lightblue' : 'lightblue' }}" />
                        </x-adminlte-profile-widget>
                    </a>
                </div>
            @endforeach
        @else
            No Invitations Approved.
        @endif
    @elseif ($status == 2)
        @if (count($offers))
            @foreach ($offers as $offer)
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <a href="{{ route('musician.invitation.show', $offer->id) }}">
                        <x-adminlte-profile-widget id="pro" name="{{ $offer->music->title }}" url="#"
                            desc="Offered by: {{ $offer->user->name }}" theme="lightblue"
                            img="{{ asset($offer->user->profile_image_url) }}" layout-type="classic">
                            <x-adminlte-profile-row-item title="Release Date"
                                text="{{ date('M d, Y', strtotime($offer->music->release_date)) }}" badge="teal" />
                            <x-adminlte-profile-row-item title="Expiration Date"
                                text="{{ date('M d, Y', strtotime($offer->expires_at)) }}" badge="teal" />
                            <x-adminlte-profile-row-item title="Status"
                                text="{{ $offer->status == 2 ? 'Complete' : 'Approved' }}"
                                badge="{{ $offer->status == 2 ? 'success' : 'lightblue' }}" />
                        </x-adminlte-profile-widget>
                    </a>
                </div>
            @endforeach
        @else
            No Invitations Completed.
        @endif

    @endif
</div>
