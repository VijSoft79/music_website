@extends('adminlte::page')

@section('title', 'Dashboard')

{{-- @section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true) --}}

@section('content_header')
    <div class="container">
        <h3>In progress Invitations</h3>
    </div>

@stop

@section('content')
    <style>
        iframe {
            width: 100%;
            height: 300px;
        }
    </style>
    <div class="conteiner-fliud">
        <div class="row">
            <div class="container pb-5">
                <div class="row">
                    @if (session('message'))
                        <div class="col-12">
                            <x-adminlte-alert theme="success" title="Success">
                                {{ session('message') }}
                            </x-adminlte-alert>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <x-adminlte-profile-widget name="{{ $music->title }}" desc="{{ $music->artist->name }}" class="elevation-4 text-capitalize" img="{{ $music->artist->profile_image_url ? $music->artist->profile_image_url : asset('/images/default-image.jpg') }}" cover="{{ $music->image_url }}" layout-type="classic" header-class="text-right text-white font-weight-bold" footer-class="bg-gradient-dark">

                            <x-adminlte-profile-col-item class="border-right text-light" icon="" title="Song Version" text="{{ $music->song_version }}" size=6 badge="lime" />
                            <x-adminlte-profile-col-item class="text-light" icon="" title="Date To be Publish" text="{{ date('M d,Y', strtotime($music->release_date)) }}" size=6 badge="danger" />
                            <x-adminlte-profile-row-item title="Contact me on:" class="text-center text-light border-bottom mb-2" />

                            
                            <div class="d-flex justify-content-center col-md-12">
                                @if ($music->artist->instagram_link)
                                    <a href="{{ $music->artist->instagram_link }}" target="_blank">
                                        <x-adminlte-profile-row-item icon="fab fa-fw fa-2x fa-instagram text-light" title="Instagram" />
                                    </a>
                                @endif
                                @if ($music->artist->facebook_link)
                                    <a href="{{ $music->artist->facebook_link }}" target="_blank">
                                        <x-adminlte-profile-row-item icon="fab fa-fw fa-2x fa-facebook text-light" title="Facebook" />
                                    </a>
                                @endif
                                @if ($music->artist->twitter_link)
                                    <a href="{{ $music->artist->twitter_link }}" target="_blank">
                                        <x-adminlte-profile-row-item icon="fab fa-fw fa-2x fa-twitter text-light" title="Twitter" />
                                    </a>
                                @endif
                            </div>
                            
                            

                        </x-adminlte-profile-widget>
                    </div>
                    <div class="col-md-6 mb-2">
                        @php
                            preg_match('/<iframe[^>]*>.*?<\/iframe>/', $music->embeded_url, $matches);
            
                            $music->embeded_url = isset($matches[0]) ? $matches[0] : null;
                        @endphp
                        <div class="d-flex">
                            {!! $music->embeded_url !!}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-primary card-outline direct-chat direct-chat-primary shadow-none">

                            <div class="card-header">
                                <h3>Invitation Info:</h3>
                            </div>
                            <div class="card-body px-5 py-3">
                                <dl class="row">
                                    <dt class="col-6">Invitation Type</dt>
                                    <dd class="col-6 text-right">{{ $template->offer_type }}</dd>

                                    <dt class="col-6">Invitation Amount</dt>
                                    <dd class="col-6 text-right">$ {{ number_format($template->offer_price, 2) }}</dd>
                                    <dt class="col-12">Description</dt>
                                    <dd class="col-12">
                                        <p>{!! $template->description !!}</p>
                                    </dd>
                                </dl>


                                <div class="row">
                                    <div class="col-12">
                                        <h3>Completion Report</h3>
                                    </div>

                                    <dt class="col-6">Url:</dt>

                                    <?php
                                    $urls = json_decode($invitationReport->url, true);
                                    ?>
                                    @foreach ($urls as $url)
                                        <dd class="col-12 text-right"><a href="{{ $url }}" target="_blank">{{ $url }}</a></dd>
                                    @endforeach


                                    <div class="row">
                                        @if ($invitationReport->images)
                                            @foreach (json_decode($invitationReport->images) as $image)
                                                <div class="col-4">
                                                    <img class="w-100" src="{{ asset('storage/' . $image) }}" alt="">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>
                            @if ($invitationReport->status == 'pending checking')
                                <div class="card-footer">
                                    <form action="{{ route('admin.invitation.complete', $offer) }}" method="post">
                                        @csrf
                                        {{-- Email type --}}
                                        <x-adminlte-input name="amount" value="{{ $template->offer_price }}" type="hidden" placeholder="mail@example.com" />
                                        <x-adminlte-button type="submit" label="Approve Completion" theme="success" icon="fas fa-thumbs-up" />
                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
