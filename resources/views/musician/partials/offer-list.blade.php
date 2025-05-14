<div class="row">
    @if (!$offers->isEmpty())
        <div class="col-md-12">
            <x-adminlte-card title="You Have New Invitations" theme="info" icon="fas fa-lg fa-bell">
               <div class="row">
                    @foreach ($offers as $offer)
                        {{-- <div class="col-md-3 p-3">

                        
                            <a class="text-dark" href="{{ route('musician.invitation.show', $offer) }}">
                                <div class="row shadow p-3 mb-2 bg-white rounded">
                                    <div class="col-3 text-center">
                                        <img class="w-50" src="{{ $offer->user->profile_image_url ? asset($offer->user->profile_image_url) : asset('images/default-image.jpg') }}" alt="">
                                        <p class="pt-3 mb-0" stytle="font-size:20px">{{ $offer->user->name }}</p>
                                    </div>
                                    <div class="col-9">
                                        <p class="h4" style="color:#000">
                                            {{ $offer->offerTemplate->basicOffer->name }}
                                        </p>
                                        <span style="font-size: 16px">song title:{{ $offer->music->title }}</span>
                                        <p class="text-truncate">{!! \Illuminate\Support\Str::limit(strip_tags($offer->offerTemplate->basicOffer->description), 100) !!}</p>
                                    </div>
                                </div>
                            </a>
                        </div> --}}

                        {{-- asdasdsa --}}

                        <div class="col-12 col-sm-6 col-md-3 artist-item" data-artist-name="#" data-artist-title="#" data-remaining-days="#" data-song-type="#">
                            <a class="text-dark" href="{{ route('musician.invitation.show', $offer) }}">
                                <div class="card card-widget widget-user shadow-lg">
                                    <div class="widget-user-header text-white" style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%), url('{{ $offer->music->image_url ? asset($offer->music->image_url) : asset('images/logo.png') }}');background-repeat:no-repeat;background-size:cover">
                                        <div>
                                            <h3 class="widget-user-username font-weight-bold text-right" style="z-index: 100">
                
                                                {{ $offer->offerTemplate->basicOffer->name }}
                                                
                                            </h3>
                                            <h5 class="widget-user-desc text-right">by: {{ $offer->user->name }}</h5>
                                        </div>
                
                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-fluid" src="{{ $offer->user->profile_image_url ? asset($offer->user->profile_image_url) : asset('images/default-image.jpg') }}" alt="User Avatar">
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                          
                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">Song</h5>
                                                    <span class="description-text">{{$offer->music->title}}</span>
                                                </div>
                                            </div>
    
                                            <div class="col-sm-8">
                                                <div class="description-block">
                                                    <h5 class="description-header">
                                                        Description
                                                    </h5>
                                                    <span class="description-text">{!! \Illuminate\Support\Str::limit(strip_tags($offer->offerTemplate->basicOffer->description), 50) !!}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </x-adminlte-card>
        </div>

        
    @endif
</div>