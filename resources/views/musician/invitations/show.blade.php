@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content')
    <style>
        iframe {
            width: 100%;
            height: 300px;
        }

        .widget-user-2 .widget-user-image>img {
            height: 65px;
        }
    </style>

    <div class="container py-2">
        <div class="row">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('musician.invitations.partials.offer-details')
            </div>

            <div class="col-md-6">
                {{-- @include('chats.chats') --}}
                @if ($offer)
                    <livewire:chat-box :offer="$offer" />
                @endif
                
            </div>

            @if ($offer->status == 0)
            {{-- pending --}}
                <div class="col-md-12">
                    @include('musician.invitations.partials.offer-list')
                </div>
            @elseif($offer->status == 1)
            {{-- in progress --}}
                <div class="col-md-12">
                    @if ($offer->freeAlternative || $offer->spotifyPlayList)
                        @include('musician.invitations.partials.free-option-details')
                    @endif
                    @include('musician.invitations.partials.invitation-details')
                </div>
            @elseif($offer->status == 2)
            {{-- completed --}}

                <div class="col-md-12">
                    <x-adminlte-card title="Report details" theme="primary" icon="fas fa-lg fa-bell">
                        <div class="row">
                            <div class="col-12">
                                <dl>
                                    <dt>Url:</dt>
                                    <?php
                                        $urls = json_decode($offer->report->url, true);
                                    ?>
                                    @foreach ($urls as $url)
                                        <dd class="col-12 text-right"><a href="{{ $url }}" target="_blank">{{ $url }}</a></dd>
                                    @endforeach
                                </dl>
                            </div>
                            @if ($offer->report->images)
                                @foreach (json_decode($offer->report->images) as $image)
                                    <div class="col-4">
                                        <img class="w-100" src="{{ asset('storage/' . $image) }}" alt="">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </x-adminlte-card>
                </div>
            @endif

        </div>
    </div>
@stop

@section('js')

<script>
    $(document).ready(function() {
        $('#approve').on('click', function(e) {  
            e.preventDefault();
            let dataType = $(this).data('type');
            let offerId = $(this).data('offer');
            let temp = $(this).data('temp');

            $.ajax({
                url: "{{ route('special.approve') }}",
                type: 'post',
                data: {
                    _token: $('input[name="_token"]').val(),
                    type: dataType,
                    offerId: offerId,
                    temp: temp
                },
                success: function(response) {
                    confirm(response.message)
                },
                error: function(error) {
                    console.log(error.responseJSON);
                }
            });
        });

        let btndecline = $('#declineBtn');
        btndecline.on('click', function(e) {
            e.preventDefault();

            let result = confirm('are you sure you want to decline this Invitation?');
            let offerId = {{ $offer->id }};

            if (result == true) {
                $.ajax({
                    url: "{{ route('musician.invitation.decline') }}",
                    type: 'post',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        offerId: offerId,
                    },
                    success: function(response) {
                        confirm(response.message);
                        window.location.replace("{{ route('musician.invitation.index') }}");
                    },
                });
            }
        });

    });
</script>

@stop
