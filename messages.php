<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Boxicons for icons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <title>Messaging Interface</title>
</head>
<body>

    <!-- Sidebar (Example) -->
    <?php include 'sidebar/sidebar.php' ?>

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php include 'header/header.php' ?>

        <?php 
		  $conn = new class_model(); 
		$Users = $conn->fetchAll_User();
        
        ?>
        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Messages</h1>
                </div>
            </div>

            <!-- Messaging Interface -->
            <div class="messaging-container">
                <!-- Left: User List -->
                <div class="user-list">
                    <h3>Contacts</h3>
                    <ul>
                        <?php  foreach($Users as $row){ 
							$pro = $row['profile_picture'];	
                            
                            ?>
                        <li class="user" data-user-id="<?php echo $row['user_id']; ?>">
                        <img src="uploads/profile_pictures/<?php  echo  $pro?>">

                        <p><?php echo $row['Fullname'] ?>(<?php echo $row['role'] ?>)</p>

                        </li>
                       <?php }; ?>
                    </ul>
                </div>

                <!-- Right: Messages -->
                <div class="chat-box">
                  <div class="messages" id="messages">
    <!-- Default Welcome Message -->
    <div class="message received">
        <p>System : Welcome to the chat for the voting system! Feel free to send a message to start voting.</p>
        <span class="time">Just now</span>
    </div>
</div>

                    <!-- Message Input -->
                    <div class="message-input">
                        <input type="text" id="messageText" placeholder="Type a message..." aria-label="Type a message">
                        <button id="sendMessage" aria-label="Send Message">Send</button>
                    </div>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <!-- Optional JavaScript -->
    <script src="script.js"></script>
    <script>
     // Declare a global variable for the receiverId
let receiverId = null;

// Add event listener to each user in the contact list
document.querySelectorAll('.user').forEach(user => {
    user.addEventListener('click', function() {
        // Set the receiverId based on the clicked user's data-user-id
        receiverId = this.dataset.userId; // Get the user ID of the clicked user
        var senderId = <?php echo $me ?>; // This should be dynamically set based on the logged-in user ID
        
        // Fetch messages for the selected user
        fetchMessages(senderId, receiverId);
    });
});

// Send message when the button is clicked
document.getElementById('sendMessage').addEventListener('click', function() {
    var messageText = document.getElementById('messageText').value;
    var senderId = <?php echo $me ?>; // Dynamically set sender_id based on the logged-in user
    
    // Check if receiverId is set (this should be assigned when a user is clicked)
    if (!receiverId) {
        alert("Please select a user to message.");
        return;
    }
    
    if (messageText.trim() === '') {
        alert("Message cannot be empty.");
        return;
    }

    // Prepare data for AJAX request
    var data = new FormData();
    data.append('message_text', messageText);
    data.append('sender_id', senderId);
    data.append('receiver_id', receiverId);

    // Send the message via AJAX to a PHP handler (e.g., send_message.php)
    fetch('controllers/send_message.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Clear the input field
            document.getElementById('messageText').value = '';

            // Append the new message to the chat box
            var messageContainer = document.getElementById('messages');
            var newMessage = document.createElement('div');
            newMessage.classList.add('message', 'sent');
            newMessage.innerHTML = `<p>${messageText}</p><span class="time">${data.timestamp}</span>`;
            messageContainer.appendChild(newMessage);
            
            // Scroll to the bottom of the messages
            messageContainer.scrollTop = messageContainer.scrollHeight;
        } else {
            alert('Error sending message. Please try again later.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while sending the message.');
    });
});


function fetchMessages(senderId, receiverId) {
    var data = new FormData();
    data.append('sender_id', senderId);
    data.append('receiver_id', receiverId);

    fetch('controllers/fetch_messages.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        var messageContainer = document.getElementById('messages');
        messageContainer.innerHTML = ''; // Clear previous messages

        if (data.status === 'success') {
            if (data.messages && data.messages.length > 0) {
                // If there are messages, display them
                data.messages.forEach(message => {
                    var messageDiv = document.createElement('div');
                    messageDiv.classList.add('message');
                    messageDiv.classList.add(message.sender_id === senderId ? 'sent' : 'received');
                    messageDiv.innerHTML = `
                        <p>${message.message_text}</p>
                        <span class="time">${message.timestamp}</span>
                    `;
                    messageContainer.appendChild(messageDiv);
                });
            } else {
                // If there are no messages, display a prompt to start the conversation
                var noMessagesMessage = document.createElement('div');
                noMessagesMessage.classList.add('message', 'received');
                noMessagesMessage.innerHTML = `
                    <p>Start a conversation with this person!</p>
                    <span class="time">Just now</span>
                `;
                messageContainer.appendChild(noMessagesMessage);
            }

            // Scroll to the bottom of the chat
            messageContainer.scrollTop = messageContainer.scrollHeight;
        } else {
            // If there are no messages, display a prompt to start the conversation
            var noMessagesMessage = document.createElement('div');
                noMessagesMessage.classList.add('message', 'received');
                noMessagesMessage.innerHTML = `
                    <p>Start a conversation with this person!</p>
                    <span class="time">Just now</span>
                `;
                messageContainer.appendChild(noMessagesMessage);
                var noMessagesMessage = document.createElement('div');
                noMessagesMessage.classList.add('message', 'received');
                noMessagesMessage.innerHTML = `
                    <p>You have No chat Yet!</p>
                    <span class="time">Just now</span>
                `;
                messageContainer.appendChild(noMessagesMessage);

        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while fetching the messages.');
    });
}


    </script>
</body>
</html>
<style>
       /* Global Reset */
       * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        
            color: #333;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .messaging-container {
            display: flex;
            height: 80vh;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            width: 90%;
            overflow: hidden;
        }

        /* User List Section */
        .user-list {
            width: 30%;
            background-color: #f1f1f1;
            padding: 20px;
            border-right: 1px solid #ddd;
            overflow-y: auto;
        }

        .user-list h3 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #555;
        }

        .user-list ul {
            list-style-type: none;
        }

        .user-list .user {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 12px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .user-list .user:hover {
            background-color: #e0e0e0;
        }

        .user-list .user img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 12px;
            border: 2px solid #ddd;
        }

        .user-list .user p {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        /* Chat Box Section */
        .chat-box {
            width: 70%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #ffffff;
            padding: 20px;
        }

        .messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 8px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .messages .message {
            margin-bottom: 15px;
            max-width: 70%;
            line-height: 1.5;
            font-size: 14px;
            padding: 12px;
            border-radius: 8px;
        }

        .messages .message.sent {
          
            background-color: #007BFF;
            color: #ffffff;
            align-self: flex-end;
        }

        .messages .message.received {
            background-color: #eaeaea;
            color: #333;
            align-self: flex-start;
        }

        .messages .message .time {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }

        /* Message Input Section */
        .message-input {
            display: flex;
            gap: 10px;
        }

        .message-input input {
            flex: 1;
            padding: 12px;
            border-radius: 25px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: border-color 0.3s ease;
            outline: none;
        }

        .message-input input:focus {
            border-color: #007BFF;
        }

        .message-input button {
            padding: 12px 20px;
            background-color: #007BFF;
            color: #ffffff;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .message-input button:hover {
            background-color: #0056b3;
        }

        .message-input button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>

