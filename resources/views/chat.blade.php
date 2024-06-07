

@section('title', env('APP_NAME'))

@include('layouts.title')

<body>

  <!-- ======= Header ======= -->
@include('layouts.header')

  <!-- ======= Sidebar ======= -->
 @include('layouts.sidebar')

  <main id="main" class="main">
<section class="section dashboard">
    <div class="row">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="sidebarUsers">
                        <h2>Online Users</h2>
                        <ul>
                            @foreach($users as $user)
                                <li class="user" data-user-id="{{ $user->id }}">
                                    <img src="{{ $user->profile_pic }}" alt="{{ $user->fullname }}" class="avatar">
                                    <span class="username">{{ $user->fullname }}</span>
                                    <span class="status {{ $user->isactive ? 'online' : 'offline' }}">{{ $user->isactive ? 'Online' : 'Offline' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            Chat
                        </div>
                        <div class="card-body">
                            <div class="chat-container overflow-auto" id="chatContainer">
                                <div class="chat-box" id="chatBox">
                                    <!-- Messages will appear here -->
                                    @foreach($messages as $message)
                                        <div class="message{{ $message->user->id == Auth::user()->id ? ' outgoing' : ' incoming' }}">
                                            <div class="message-details{{ $message->user->id == Auth::user()->id ? ' text-end' : '' }}">
                                                <span class="message-sender"><strong>{{ $message->user->fullname }}</strong></span>
                                                <span class="message-time">{{ $message->created_at_formatted }} <i class="bi bi-clock"></i> </span>
                                                <span class="message-icon">
    @if($message->is_read)
        <i class="bi bi-book-fill"></i>
    @else
        <i class="bi bi-book"></i>
    @endif
</span>

                                            </div>
                                            <div class="message-content{{ $message->user->id == Auth::user()->id ? ' outgoing' : ' incoming' }}" onclick="displayMessage('{{ $message->message }}')">{{ $message->message }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <form id="chatForm" action="{{ route('chat.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="receiver_id" id="receiverId" value="">
                                <div class="input-group">
                                    <input type="text" class="form-control chat-input" placeholder="Type your message..." id="messageInput" name="message">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        // Event listener for clicking on user elements
        $('.user').click(function() {
            var userId = $(this).data('user-id');
            startChat(userId); // Call function to start chatting with the clicked user
            $('#chatBox').show(); // Show the chatbox when starting a chat
        });

        $('#chatForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST", // Specify the method as POST
                url: $(this).attr('action'), // Use the action attribute of the form
                data: $(this).serialize(),
                success: function(response) {
                    if (response.message && response.newMessage) {
                        toastr.success(response.message); // Show success message using toastr

                        var messageHtml = '<div class="message' + (response.newMessage.user_id == response.user.id ? ' outgoing' : ' incoming') + '">' +
                            '<div class="message-details' + (response.newMessage.user_id == response.user.id ? ' text-end' : '') + '">' +
                            '<span class="message-sender"><strong>' + response.user.fullname + '</strong></span>' +
                            '<span class="message-time">' + moment(response.newMessage.created_at).format('M D, Y H:i A') + ' <i class="bi bi-clock"></i> </span>' +
                            '<span class="message-icon"></span>' + // Container for the message icon
                            '</div>' +
                            '<div class="message-content' + (response.newMessage.user_id == response.user.id ? ' outgoing' : ' incoming') + '">' + response.newMessage.message + '</div>' +
                            '</div>';
                        $('#chatBox').prepend(messageHtml); // Prepend the new message instead of appending

                        // Clear the message input field
                        $('#messageInput').val('');

                        // Scroll to the bottom of the chat
                        scrollToBottom();

                        // Get the newly prepended message and update the message icon
                        var newMessage = $('#chatBox').find('.message').first();
                        handleMessageStatus(newMessage);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseJSON.error || 'Failed to send message.'); // Show error message using toastr
                }
            });
        });
    });

    // Function to update the message icon based on its read status
    function updateMessageIcon(message) {
        var icon = message.is_read ? '<i class="bi bi-book-fill"></i>' : '<i class="bi bi-book"></i>';
        message.find('.message-icon').html(icon);
    }

    // Call this function after appending a new message
    function handleMessageStatus(message) {
        // Update the message icon based on its read status
        updateMessageIcon(message);
    }

    function scrollToBottom() {
        var chatContainer = document.getElementById('chatContainer');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Function to fetch updated chat data
    function fetchChatData(userId) {
        $.ajax({
            url: '/get-chat-data/' + userId,
            type: 'GET',
            success: function(response) {
    if (response.message && response.newMessage) {
        toastr.success(response.message); // Show success message using toastr

        response.messages.forEach(function(message) {
            var messageHtml = '<div class="message' + (message.user.id == response.user.id ? ' outgoing' : ' incoming') + '">' +
                '<div class="message-details' + (message.user.id == response.user.id ? ' text-end' : '') + '">' +
                '<span class="message-sender"><strong>' + message.user.fullname + '</strong></span>' +
                '<span class="message-time">' + message.created_at_formatted + ' <i class="bi bi-clock"></i> </span>' +
                '<span class="message-icon"></span>' + // Container for the message icon
                '</div>' +
                '<div class="message-content' + (message.user.id == response.user.id ? ' outgoing' : ' incoming') + '" onclick="displayMessage(\'' + message.message + '\')">' + message.message + '</div>' +
                '</div>';
            $('#chatBox').append(messageHtml);
        });

        $('#chatBox').show(); // Show the chat box
        scrollToBottom(); // Scroll to the bottom of the chat
    }
},

            error: function(xhr, status, error) {
                toastr.error('Failed to fetch chat data.'); // Show error message using toastr
            }
        });
    }

    function startChat(userId) {
        $('#receiverId').val(userId); // Set the receiver ID
        fetchChatData(userId); // Fetch chat data for the selected user
    }
</script>

 

  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>

 

  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>