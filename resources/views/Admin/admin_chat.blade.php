{{-- ADMIN CHAT --}}
@extends('layouts.main')

@section('title', 'Chat Management - Atlantis Lite')

@push('styles')
<style>
    .chat-container {
        display: flex;
        height: calc(100vh - 150px);
        border-radius: 10px;
        overflow: hidden;
        background-color: #e5ddd5;
    }
    .contact-list {
        width: 30%;
        background-color: #fff;
        border-right: 1px solid #ddd;
        overflow-y: auto;
    }
    .contact-item {
        display: flex;
        align-items: center;
        padding: 10px;
        gap: 10px;
        border-bottom: 1px solid #f1f1f1;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .contact-item:hover, .contact-item.active {
        background-color: #f0f0f0;
    }
    .contact-avatar {
        width: 40px;
        height: 40px;
        background-color: #ccc;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        font-size: 18px;
        color: white;
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
</style>
@endpush

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Chat Management</h2>
                <h5 class="text-white op-7 mb-2">Communicate with Customers</h5>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">Chat Interface</div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    <div class="chat-container">
                        <div class="contact-list">
                            @forelse ($customers as $customer)
                                <div class="contact-item" data-user-id="{{ $customer->id }}">
                                    <div class="contact-avatar">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                                    <div>
                                        <div><strong>{{ $customer->name }}</strong></div>
                                        <div class="text-muted" style="font-size: 12px;">
                                            {{ $customer->email }}
                                            @php
                                                $unreadCount = \App\Models\Message::where('sender_id', $customer->id)
                                                    ->where('receiver_id', Auth::id())
                                                    ->where('is_read', false)
                                                    ->count();
                                            @endphp
                                            @if ($unreadCount > 0)
                                                <span class="badge badge-primary">{{ $unreadCount }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="contact-item text-center">No customers found.</div>
                            @endforelse
                        </div>
                        <div class="chat-area">
                            <div class="chat-header" id="chat-header">
                                Select a customer to start chatting
                            </div>
                            <div class="chat-messages" id="chat-messages">
                                <!-- Messages will be dynamically added here -->
                            </div>
                            <div class="message-input">
                                <form id="message-form">
                                    @csrf
                                    <input type="text" name="message" id="message-input" placeholder="Type a message..." required disabled>
                                    <button type="submit" class="btn btn-send" disabled>
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
@endsection

@push('scripts')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Pusher
    Pusher.logToConsole = true; // For debugging
    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });

    // Subscribe to channel
    var channel = pusher.subscribe('private-chat');
    var currentUserId = null;

    // Handle contact selection
    $('.contact-item').on('click', function() {
        $('.contact-item').removeClass('active');
        $(this).addClass('active');

        currentUserId = $(this).data('user-id');
        var userName = $(this).find('strong').text();
        $('#chat-header').html(`<strong>${userName}</strong><br><small>Online</small>`);
        $('#message-input, .btn-send').prop('disabled', false);

        // Load messages
        $.ajax({
            url: '{{ route('admin.chat.messages', ':receiverId') }}'.replace(':receiverId', currentUserId),
            method: 'GET',
            success: function(response) {
                $('#chat-messages').empty();
                response.forEach(function(msg) {
                    var messageClass = msg.is_sent ? 'sent' : 'received';
                    $('#chat-messages').append(`
                        <div class="message ${messageClass}">
                            ${msg.message}
                            <div class="message-time">${new Date(msg.created_at).toLocaleTimeString()}</div>
                        </div>
                    `);
                });
                $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
            },
            error: function(xhr) {
                alert('Failed to load messages. Please try again.');
            }
        });
    });

    // Send message
    $('#message-form').on('submit', function(e) {
        e.preventDefault();
        if (!currentUserId) {
            alert('Please select a customer to chat with.');
            return;
        }

        var message = $('#message-input').val().trim();
        if (!message) return;

        $.ajax({
            url: '{{ route('admin.chat.send') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                receiver_id: currentUserId,
                message: message
            },
            success: function(response) {
                $('#message-input').val('');
                $('#chat-messages').append(`
                    <div class="message sent">
                        ${response.message}
                        <div class="message-time">${new Date(response.created_at).toLocaleTimeString()}</div>
                    </div>
                `);
                $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
            },
            error: function(xhr) {
                alert('Failed to send message. Please try again.');
            }
        });
    });

    // Listen for new messages
    channel.bind('App\\Events\\MessageSent', function(data) {
        if (data.sender_id == currentUserId && data.receiver_id == '{{ Auth::id() }}') {
            $('#chat-messages').append(`
                <div class="message received">
                    ${data.message}
                    <div class="message-time">${new Date(data.created_at).toLocaleTimeString()}</div>
                </div>
            `);
            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);

            // Update unread count
            var contactItem = $(`.contact-item[data-user-id="${data.sender_id}"]`);
            var unreadBadge = contactItem.find('.badge');
            var currentCount = parseInt(unreadBadge.text()) || 0;
            unreadBadge.text(currentCount + 1);
        }
    });
});
</script>
@endpush