<div class="card card-primary card-outline direct-chat direct-chat-primary shadow-none" >
    <div class="card-header">
        <h3 class="card-title">Message</h3>
    </div>


    <div class="card-body">
        {{-- get chat message and fetch messages with 500ms --}}
        <div class="direct-chat-messages" id="messages" style="flex: 1; overflow-y: auto; scroll-behavior: smooth; height: 330px;"
            wire:poll.500ms="loadMessages">
            @foreach ($messages as $message)
                @if ($message->sender_id === auth()->id())
                    <div class="w-50 ml-auto direct-chat-msg right">
                        <div class="text-right direct-chat-text bg-primary text-white">
                            {{ $message->content }}
                        </div>
                    </div>
                @else
                    <div class="w-50 mr-auto direct-chat-text">
                        <div class="text-left direct-chat-text">
                            {{ $message->content }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>


        <div class="card-footer bg-secondary">
            <div class="input-group">
                <input wire:model.defer="content" wire:keydown.enter="sendMessage" type="text" class="form-control"
                    placeholder="Type Message ...">
                <span class="input-group-append">
                    <button wire:click="sendMessage" class="btn btn-primary">Send</button>
                </span>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messagesDiv = document.getElementById('messages');
            
            // Function to scroll the chat to the bottom
            function scrollToBottom() {
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }

            // Scroll to the bottom initially
            scrollToBottom();

            // Listen for changes to the messages div (e.g., when new messages are added)
            let observer = new MutationObserver(() => {
                scrollToBottom();
            });

            // Observe changes in the chat messages container
            observer.observe(messagesDiv, { childList: true, subtree: true });
        });
    </script>
@endpush
