<div>
    <div class="my-2">
        <div class="card">
            <div class="card-body py-0 px-2">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-default my-1" data-toggle="modal" data-target="#modal-xl">
                            Filter By Genre
                        </button>
                    </div>
                    <div class="col-md-3">
                        <select wire:model.live="sortBy" class="btn-default form-control my-1">
                            <option value="default">Sort By</option>
                            <option value="sort_date">Date Expire</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select wire:model.live="songType" class="btn-default form-control my-1">
                            <option value="">Select song type</option>
                            <option value="default">Single</option>
                            <option value="video">Video</option>
                            <option value="ep">EP</option>
                            <option value="album">Album</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" wire:model.live="searchQuery" class="form-control my-1" placeholder="Search by title...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" wire:loading.class="opacity-50">
        @foreach ($musics as $music)
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <a class="text-dark text-decoration-none" href="{{ route('curator.submissions.show', $music->id) }}">
                    <div class="card card-widget widget-user shadow-sm hover-shadow-lg transition-shadow">
                        <div class="widget-user-header text-white position-relative overflow-hidden" style="height: 200px; padding:0;">
                            <img 
                                loading="lazy"
                                class="position-absolute w-100 h-100 object-fit-cover"
                                src="{{ asset($music->image_url) }}"
                                alt="{{ $music->title }}"
                                style="top: 0; left: 0;"
                                onerror="this.src='{{ asset($music->artist->profile_image_url) }}'"
                            >
                            <div class="position-relative z-1 p-3 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,rgba(0,0,0,0.8) 100%);">
                                <h3 class="widget-user-username font-weight-bold text-right text-truncate">
                                    {{ $music->title }}
                                </h3>
                                <h5 class="widget-user-desc text-right text-truncate">by: {{ $music->artist->band_name }}</h5>
                            </div>
                        </div>
                        <div class="widget-user-image">
                            <img 
                                loading="lazy"
                                class="img-fluid rounded-circle"
                                src="{{ $music->artist->profile_image_url ? $music->artist->profile_image_url : asset('images/default-image.jpg') }}"
                                alt="{{ $music->artist->name }}"
                                style="width: 90px; height: 90px; object-fit: cover;"
                            >
                        </div>
                        <div class="card-footer bg-white">
                            <div class="row">
                                <div class="col-12 text-center mb-2">
                                    <span class="badge badge-warning">{{ round($music->remainingDays()) }} Days left</span>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        {{-- <h5 class="description-header text-truncate">{{ $music->artist->name }}</h5> --}}
                                        <span class="description-text">{{ $music->song_version }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header text-capitalize">{{ $music->release_type }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            {{ $music->created_at->format('M d,Y') }}
                                        </h5>
                                        <span class="description-text text-truncate">{{ $music->artist->location ?: 'Unknown' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @if($musics->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $musics->links() }}
        </div>
    @endif

    <div class="modal fade" id="modal-xl" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select Your Genre</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($genres as $genre)
                        <h5>
                            <div class="form-check">
                                <input class="form-check-input" value="{{ $genre->id }}" type="checkbox" wire:model="selectedGenres" @if (in_array($genre->id, $userGenreIds)) checked @endif>
                                <label class="form-check-label">{{ $genre->name }}</label>
                            </div>
                        </h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="row">
                                        @foreach ($genre->childGenres as $children)
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" value="{{ $children->id }}" type="checkbox" wire:model="selectedGenres" @if (in_array($children->id, $userGenreIds)) checked @endif>
                                                    <label class="form-check-label">{{ $children->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" wire:click="updateGenres($wire.selectedGenres)" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('css')
    <style>
        .opacity-50 {
            opacity: 0.5;
            pointer-events: none;
        }
        
        .transition-shadow {
            transition: box-shadow 0.3s ease-in-out;
        }
        
        .hover-shadow-lg:hover {
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }
        
        .object-fit-cover {
            object-fit: cover;
        }
        
        .z-1 {
            z-index: 1;
        }
        
        /* Loading placeholder animation */
        @keyframes placeholder-loading {
            0% { background-position: -200px 0 }
            100% { background-position: 200px 0 }
        }
        
        .loading-placeholder {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200px 100%;
            animation: placeholder-loading 1.5s infinite linear;
        }
        
        [wire\:loading] .widget-user-header img {
            opacity: 0.5;
        }
    </style>
@endsection
