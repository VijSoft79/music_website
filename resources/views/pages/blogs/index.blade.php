@extends('layouts.app')
@section('content')

    <div class="hidden md:flex w-3/5 mx-auto gap-2">
        @if($posts[0]->status == 'publish')
            <div class="w-1/2 px-10 py-20 rounded-lg" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $posts[0]->featured_image }}'); background-repeat: no-repeat; background-size: cover;">
                <h2 class="card-title text-3xl">
                    <a href="{{ route('page.blog.show', $posts[0]->slug) }}">{{ $posts[0]->title }}</a>
                </h2>
                <p>{!! strip_tags($posts[0]->exerpt()) !!}</p>
            </div>
        @endif
        @if ($posts[1]->status == 'publish')
            <div class="w-1/2 px-10 py-20 rounded-lg" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $posts[1]->featured_image }}'); background-repeat: no-repeat; background-size: cover;">
                <h2 class="card-title text-3xl">
                    <a href="{{ route('page.blog.show', $posts[1]->slug) }}">{{ $posts[1]->title }}</a>
                </h2>
                <p>{!! $posts[1]->exerpt() !!}</p>
            </div>
        @endif
    </div>


    <div class="py-3 lg:w-3/5 mx-auto lg:flex gap-2">
        <div class="w-full lg:flex-grow">
            @if ($posts->count() >= 3)
                @foreach ($posts->slice(2) as $post)
                    <div class="card lg:card-side bg-base-100 shadow-xl mb-4 ">
                        <img class="w-full md:w-1/2 " src="{{ $post->featured_image }}" alt="Album" />
                        <div class="card-body">
                            <h2 class="card-title">
                                <a href="{{ route('page.blog.show', $post->slug) }}" class="line-clamp-2">{{ $post->title }}</a>
                            </h2>
                            <p>{!! $post->exerpt() !!}</p>
                            <div class="card-actions justify-end">
                                <a href="{{ route('page.blog.show', $post->slug) }}" class="btn btn-primary">Read</a>
                            </div>
                        </div>
                    </div>
                    
                @endforeach
            @endif
            <div class="flex justify-center my-4">
                <div class="flex space-x-2">
                    {{ $posts->onEachSide(5)->links()}}
                </div>
            </div>
        </div>
       
        <div class="w-full lg:basis-2/6 ">
            <div class="p-4 card bg-base-100 shadow-xl mb-4">
                <h2 class="text-xl font-semibold">Recently Added</h2>
                <ul>
                    @foreach ($recents as $recent)
                        <a href="{{ route('page.blog.show', $recent->slug) }}" class="underline underline-offset-1 line-clamp-2 my-3">{{ $recent->title }}</a>
                        {{-- <li class="underline underline-offset-1 line-clamp-2 my-3">{{ $recent->title }}</li>   --}}
                        
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    
    <dialog id="my_modal_1" class="modal">
        @php
            $popup = App\Models\PageContent::where('title', 'blog page popup')->first();
        @endphp
        <div class="modal-box bg-[#1e293b] text-white">
            <h3 class="text-3xl font-bold">Get your songs heard!</h3>
            {!! $popup->content !!}
            <a href="{{ route('user.type.choose') }}" class="btn btn-primary w-full mt-5">Join here!</a>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
@endsection

@section('js')
    <script>
        function showModal() {
            const modal = document.getElementById('my_modal_1');
            modal.showModal();
        }

        // Set timeout to show modal after 10 seconds
        setTimeout(showModal, 2000);
    </script>
@endsection
