<style>
    .direct-chat-messages {
        flex: 1;
        /* Ensures it takes available space */
        overflow-y: auto;
        /* Enables vertical scrolling */
        scroll-behavior: smooth;
        /* Smooth scrolling */
        height: 300px;
        /* Example height, adjust as needed */
    }
</style>
<div class="card card-primary card-outline direct-chat direct-chat-primary shadow-none" style="min-height: 97%;">
    <div class="card-header">
        <h3 class="card-title">Message</h3>
    </div>

    <div class="card-body" >
        <div class="direct-chat-messages" id="messages">
            @foreach ($messages as $message)
                @if ($message->sender_id == Auth::user()->id)
                    <div class="w-50 ml-auto direct-chat-msg right">
                        <div class="text-right direct-chat-text">
                            {{ $message->content }}
                        </div>
                    </div>
                @else
                    <div class="w-50 mr-auto direct-chat-text">
                        <div class="text-left direct-chat-text m-0">
                            {{ $message->content }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="card-footer bg-secondary">
        <div class="input-group">
            <input type="text" id="messageInput" name="messageInput" placeholder="Type Message ..." class="form-control">
            <span class="input-group-append">
                <button id="sendButton" type="submit" class="btn btn-primary">Send</button>
            </span>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Scroll to bottom function
            function scrollToBottom() {
                let messagesDiv = document.getElementById('messages');
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }

            // Initialize the scroll position when the page loads
            scrollToBottom();

            // Ably Realtime subscription and message handling
            let ably = new Ably.Realtime('yMghbQ.jOLhfg:NN6OdJSACpbwxI_5hx03Jta7_1csoE849g4xuvrPekg');
            let channel = ably.channels.get('chat');
            let messageInput = document.getElementById('messageInput');
            let messagesDiv = document.getElementById('messages');

            channel.subscribe('messageEvent', function(message) {
                if (message.data.receiver == '{{ $music->artist->id }}' || message.data.sender == '{{ Auth::user()->id }}' || message.data.offer == '{{$offer->id}}') {
                    let messageElement = document.createElement('div');

                    if (message.data.sender == '{{ Auth::user()->id }}') {
                        messageElement.classList.add('direct-chat-msg', 'right');
                    } else {
                        messageElement.classList.add('direct-chat-msg');
                    }

                    let messageElementText = document.createElement('div');
                    messageElementText.classList.add('direct-chat-text');
                    messageElementText.textContent = message.data.text;

                    // Append new message
                    messageElement.appendChild(messageElementText);
                    messagesDiv.appendChild(messageElement);

                    // Scroll to bottom after adding a new message
                    scrollToBottom();
                }
                
            });

            // Send message function
            function sendMessage(sender, receiver) {
                let content = messageInput.value.trim();
                let offer = '{{ $offer->id }}';

                if (content !== '') {
                    channel.publish('messageEvent', {
                        text: content,
                        sender: sender,
                        receiver: receiver,
                        offer:offer
                    });

                    //get saved images
                    fetch('/message', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: JSON.stringify({
                                sender: sender,
                                receiver: receiver,
                                content: content,
                                offer: offer
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            messageInput.value = '';
                            // Scroll to bottom after sending a message
                            scrollToBottom();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }

            let userRoles = @json(Auth::user()->getRoleNames()); // This will be a JSON array

            // Attach sendMessage function to the send button
            $('#sendButton').on('click', function() {
                
                // identify weather the user is curator or musician
                if(userRoles.includes('curator')){
                    let sender = '{{ Auth::user()->id }}';
                    let receiver = '{{ $music->artist->id }}';
                    sendMessage(sender, receiver);
                }else{
                    let sender = '{{ Auth::user()->id }}';
                    let receiver = '{{ $offer->user->id }}';
                    sendMessage(sender, receiver);
                }
            });

            $('#messageInput').keypress(function (e) {
                let key = e.which;
                if(key == 13) 
                {
                    $('#sendButton').click();
                    messageInput.value = '';
                    return false;  
                }
            });   
        });
    </script>
@endpush
