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
    
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            font-family: 'Lato', sans-serif;
        }
        
        .header {
            background: linear-gradient(to right, #5867DD, #1e3c72);
            color: white;
            padding: 20px 30px;
        }
        
        .content-wrapper {
            padding: 20px;
            margin-top: -30px;
        }
        
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .chat-container {
            display: flex;  
            height: 75vh;
            border-radius: 10px;
            overflow: hidden;
            background-color: #e5ddd5;
        }
        
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: url('https://www.toptal.com/designers/subtlepatterns/patterns/symphony.png') repeat;
            background-size: cover;
        }
        
        .chat-header {
            padding: 15px;
            background-color: #5867DD;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        .message {
            max-width: 60%;
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 14px;
        }
        
        .message.sent {
            background-color: #dcf8c6;
            align-self: flex-end;
            border-bottom-right-radius: 5px;
        }
        
        .message.received {
            background-color: white;
            align-self: flex-start;
            border-bottom-left-radius: 5px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .message-time {
            font-size: 10px;
            color: #888;
            margin-top: 5px;
            text-align: right;
        }
        
        .message-input {
            padding: 10px;
            background-color: #f0f0f0;
            border-top: 1px solid #ddd;
        }
        
        .message-input form {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .message-input input {
            flex: 1;
            padding: 10px 15px;
            border-radius: 30px;
            border: 1px solid #ccc;
            outline: none;
        }
        
        .btn-send {
            background-color: #5867DD;
            color: white;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            border: none;
        }
        
        .btn-send:hover {
            background-color: #2d3eb9;
        }
        
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #28a745;
            margin-right: 5px;
            display: inline-block;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .chat-container {
                flex-direction: column;
                height: 85vh;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Customer Support</h2>
        <p class="mb-0">We're here to help you</p>
    </div>
    
    <div class="container-fluid content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Chat with Customer Support</div>
                        
                        <!-- Alert messages -->
                        <div class="alert alert-success alert-dismissible fade show d-none" role="alert" id="success-alert">
                            <span id="success-message"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        
                        <div class="alert alert-danger alert-dismissible fade show d-none" role="alert" id="error-alert">
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
                                    <!-- Messages will be loaded dynamically -->
                                    <div class="message received">
                                        Welcome to our customer support! How can we help you today?
                                        <div class="message-time">just now</div>
                                    </div>
                                </div>
                                <div class="message-input">
                                    <form id="message-form">
                                        <input type="text" name="message" id="message-input" placeholder="Type a message..." required>
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
            const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
                cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
                encrypted: true,
                authEndpoint: '/pusher/auth'
            });

            // Subscribe to private channel
            const channel = pusher.subscribe('private-chat');
            
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
                    url: '{{ route("customer.chat.send") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: message
                    },
                    success: function(response) {
                        $('#message-input').val('');
                        appendMessage(message, 'sent', new Date());
                    },
                    error: function(xhr) {
                        showError('Failed to send message. Please try again.');
                    }
                });
            });
            
            // Function to load previous messages
            function loadMessages() {
                $.ajax({
                    url: '{{ route("customer.chat.messages") }}',
                    method: 'GET',
                    success: function(response) {
                        $('#chat-messages').empty();
                        
                        if (response.length === 0) {
                            appendMessage('Welcome to our customer support! How can we help you today?', 'received', new Date());
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
            
            // Function to append message to chat
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
                audio.play();
            }
        });
    </script>
</body>
</html>