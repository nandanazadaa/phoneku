<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Support Chat</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/user_chat.css') }}">

</head>

<body>
    <div class="header">
        <h2>Chat</h2>
        <p class="mb-0">We're here to help you</p>
    </div>

    <div class="container-fluid content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Chat with Admin</div>

                        <!-- Alert messages -->
                        <div class="alert alert-success alert-dismissible fade show d-none" role="alert"
                            id="success-alert">
                            <span id="success-message"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="alert alert-danger alert-dismissible fade show d-none" role="alert"
                            id="error-alert">
                            <span id="error-message"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <!-- Chat interface -->
                        <div class="chat-container">
                            <div class="chat-area">
                                <div class="chat-header">
                                    <div class="status-indicator"></div>
                                    <strong>Customer Support</strong> <small>(Online)</small>
                                </div>
                                <div class="chat-messages" id="chat-messages">
                                    <div class="message received">
                                        Welcome to our customer support! How can we help you today?
                                        <div class="message-time">{{ now()->format('H:i') }}</div>
                                    </div>
                                </div>
                                <div class="message-input">
                                    <form id="message-form">
                                        @csrf
                                        <input type="text" name="message" id="message-input"
                                            placeholder="Type a message..." required>
                                        <button type="submit" class="btn btn-send">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Pusher
            const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true,
                authEndpoint: '/pusher/auth'
            });

            // Subscribe to private channel
            const channel = pusher.subscribe('private-chat.{{ Auth::id() }}');

            // Load previous messages
            loadMessages();

            // Listen for new messages
            channel.bind('App\\Events\\MessageSent', function(data) {
                if (data.receiver_id == '{{ Auth::id() }}') {
                    appendMessage(data.message, 'received', new Date(data.created_at));
                    playNotificationSound();
                }
            });

            // Send message
            $('#message-form').on('submit', function(e) {
                e.preventDefault();

                const message = $('#message-input').val().trim();
                if (!message) return;

                $.ajax({
                    url: '{{ route('chat.send') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: message,
                        receiver_id: '{{ $support->id }}'
                    },
                    success: function(response) {
                        $('#message-input').val('');
                        appendMessage(response.message, 'sent', new Date(response.created_at));
                    },
                    error: function(xhr) {
                        showError('Failed to send message. Please try again.');
                    }
                });
            });

            // Function to load previous messages
            function loadMessages() {
                $.ajax({
                    url: '{{ route('chat.messages', ['receiverId' => $support->id]) }}',
                    method: 'GET',
                    success: function(response) {
                        $('#chat-messages').empty();
                        if (response.length === 0) {
                            appendMessage('Welcome to our customer support! How can we help you today?',
                                'received', new Date());
                        } else {
                            response.forEach(function(msg) {
                                const messageClass = msg.is_sent ? 'sent' : 'received';
                                appendMessage(msg.message, messageClass, new Date(msg.created_at));
                            });
                        }
                        scrollToBottom();
                    },
                    error: function(xhr) {
                        showError('Failed to load messages. Please refresh the page.');
                    }
                });
            }

            // Function to append message
            function appendMessage(text, type, time) {
                $('#chat-messages').append(`
                <div class="message ${type}">
                    ${text}
                    <div class="message-time">${time.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                </div>
            `);
                scrollToBottom();
            }

            // Function to scroll chat to bottom
            function scrollToBottom() {
                const container = $('#chat-messages');
                container.scrollTop(container[0].scrollHeight);
            }

            // Function to show error
            function showError(message) {
                $('#error-message').text(message);
                $('#error-alert').removeClass('d-none').addClass('show');
                setTimeout(function() {
                    $('#error-alert').removeClass('show').addClass('d-none');
                }, 5000);
            }

            // Function to play notification sound
            function playNotificationSound() {
                const audio = new Audio('/assets/sounds/notification.mp3');
                audio.play().catch(function(error) {
                    console.error('Failed to play notification sound:', error);
                });
            }
        });
    </script>
</body>

</html>