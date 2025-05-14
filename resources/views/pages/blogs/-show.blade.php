@extends('layouts.app')
@section('content')
    <div class="w-full h-56 bg-center" style="background:url('{{ $blog->featured_image }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">

    </div>
    <div class="p-3 lg:w-3/5 mx-auto lg:flex gap-2">

        <div class="w-full lg:flex-grow">
            <article class="prose dark:prose-invert">
                <h1 class="m-0">{{ $blog->title }}</h1>
                @foreach ($blog->category as $category)
                    <small>{{ $category->name }}</small>
                @endforeach
                <p class="text-color:[#fff]">{!! str_replace(chr(194), ' ', $blog->content) !!}</p>
            </article>
        </div>
        <div class="w-full lg:basis-1/4 ">
            <div class="p-4 card bg-base-100 shadow-xl mb-4">
                <h2 class="text-2xl font-semibold">Recently Added</h2>
                <ul>
                    @foreach ($recents as $recent)
                        <li class="underline underline-offset-1 line-clamp-2 my-3">{{ $recent->title }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    {{-- <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Hello!</h3>
            <p class="py-4">Please Login</p>
            <div class="modal-action">
            <form method="dialog">
                <!-- if there is a button in form, it will close the modal -->
                <button class="btn">Close</button>
            </form>
            </div>
        </div>
    </dialog> --}}
@endsection
@section('js')
    {{-- <script>
    function showModal() {
            const modal = document.getElementById('my_modal_1');
            modal.showModal();
        }

        // Set timeout to show modal after 10 seconds
        setTimeout(showModal, 10000);
</script> --}}
@endsection
