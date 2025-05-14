<div class="card card-primary card-outline" wire:poll.10s>
    <div class="card-header">
        <h3 class="card-title">Inbox</h3>
    </div>
    <div class="card-body p-0">
        <div class="mailbox-controls">
            <div class="float-right">
                1-{{ count($chats) }}/{{ count($chats) }}
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
        <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
                <tbody>

                    @forelse ($chats as $offerId => $chat)
                        @php

                            $firstChat = $chat->first();
                            $offer = $firstChat->offer ?? null;
                            $music = $offer->music ?? null;
                            $musicTitle = $music->title ?? 'Unknown Title';
                            $messageCount = $chat->count();
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
                            
                        @endphp

                        <tr>

                            @if ($chat->contains('status', 'unread'))
                                <td class="mailbox-circle text-center align-middle">
                                    <span class="badge rounded-circle bg-danger">
                                        <i class="fa-solid fa-exclamation px-1 py-0"></i>
                                    </span>
                                </td>
                            @else
                                <td class="mailbox-circle"></td>
                            @endif


                            <td class="mailbox-name">
                                <a href="{{ route('chat.show', $offerId) }}">
                                    {{ $musicTitle }}
                                    ({{ $offer->offer_type ?? 'Unselected Offer' }})
                                </a>

                            </td>
                            <td class="mailbox-subject">
                                <p>{{ \Illuminate\Support\Str::limit($shortContent, 40, '...') }}</p>
                            </td>
                            <td class="mailbox-date">{{ $timeAgoText }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No messages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
