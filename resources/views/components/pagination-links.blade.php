@props(['items'])

@if ($items instanceof \Illuminate\Contracts\Pagination\Paginator && $items->hasPages())
    <div class="col-12 mt-4 d-flex justify-content-center"> {{-- Styling container --}}
        {{ $items->links() }}
    </div>
@endif 