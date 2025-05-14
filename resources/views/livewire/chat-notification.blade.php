<div wire:poll.10s>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge text-bold">{{ $count > 0 ? '!' : '' }}</span>
        </a>

        {{-- dropdown nav --}}
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            @forelse ($groupUnread as $offerId => $chats)
                @php
                    $firstChat = $chats->first();
                    $lastChat = $chats->last();
                    $offer = $firstChat->offer ?? null;
                    $music = $offer->music ?? null;
                    $musicTitle = $music->title ?? 'Untitled';
                    $imageUrl = $music->image_url ?? ' '; // default image if needed
                    $messageCount = $chats->count();
                    $shortContent = \Illuminate\Support\Str::words($firstChat->content ?? '', 2, '...');

                    $createdAt = \Carbon\Carbon::parse($firstChat->created_at ?? now());
                    $diffInMinutes = (int) $createdAt->diffInMinutes(now());
                    $diffInHours = (int) $createdAt->diffInHours(now());

                    if ($diffInMinutes < 1) {
                        $timeAgoText = 'Just now';
                    } elseif ($diffInHours < 1) {
                        $timeAgoText = $diffInMinutes . ' Minute' . ($diffInMinutes !== 1 ? 's' : '') . ' Ago';
                    } elseif ($diffInHours < 24) {
                        $timeAgoText = $diffInHours . ' Hour' . ($diffInHours !== 1 ? 's' : '') . ' Ago';
                    } else {
                        $daysAgo = floor($diffInHours / 24);
                        $timeAgoText = $daysAgo . ' Day' . ($daysAgo !== 1 ? 's' : '') . ' Ago';
                    }

                    $offerRoute = auth()->user()->hasRole('curator')
                        ? route('curator.offers.show', $offerId)
                        : route('musician.invitation.show', $offerId);

                @endphp
                
                <a href="{{ $offerRoute }}" class="dropdown-item">
                    <div class="media">
                        <img src="{{ asset($imageUrl) }}" alt="Avatar Image" class="img-size-50 mr-3 img-circle" style="width: 70px; height: 70px; object-fit: cover; border-radius: 50%;">
                        <div class="media-body">
                            <h3 class="dropdown-item-title d-flex justify-content-between">
                                <span>{{ \Illuminate\Support\Str::limit($musicTitle, 20, '...') }}</span>
                                <span class="badge badge-danger text-bold">{{ $messageCount }}</span>
                            </h3>
                            <p class="text-sm">{{ $shortContent }}</p>
                            <p class="text-sm text-muted">
                                <i class="far fa-clock mr-1"></i> {{ $timeAgoText }}
                            </p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
            @empty
                <div class="dropdown-item text-center text-muted">
                    No unread messages.
                </div>
            @endforelse
            <a href="{{route('chat.index')}}" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
    </li>
</div>
