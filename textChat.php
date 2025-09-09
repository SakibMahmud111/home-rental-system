<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chat System</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    </style>
</head>
<body>

    <div class="flex flex-col h-[80vh] w-full max-w-md bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="flex items-center p-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
            <h1 class="text-xl font-bold text-gray-800">Conversation</h1>
        </div>

        <div id="chat-log" class="flex-1 overflow-y-auto p-4 flex flex-col space-y-4">
            <!-- Sample messages -->
            <div class="max-w-[70%] bg-gray-200 text-gray-800 p-3 rounded-xl self-start">
                <p>Hello! How can I help you?</p>
            </div>
            <div class="max-w-[70%] bg-blue-500 text-white p-3 rounded-xl self-end">
                <p>Hi! I'm interested in the house you posted. Is it still available?</p>
            </div>
        </div>

        <form id="chat-form" class="flex p-4 border-t border-gray-200 bg-gray-50 rounded-b-xl">
            <input type="text" id="chat-input" placeholder="Type a message..." class="flex-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
            <button type="submit" class="ml-4 px-6 py-3 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                Send
            </button>
        </form>
    </div>

    <script>
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatLog = document.getElementById('chat-log');

        chatForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const messageText = chatInput.value.trim();
            if (messageText === '') {
                return;
            }

            addMessage('You', messageText, 'self-end bg-blue-500 text-white');

            setTimeout(() => {
                const replyText = "Yes, the house is still available. Would you like to schedule a viewing?";
                addMessage('Owner', replyText, 'self-start bg-gray-200 text-gray-800');
            }, 1000);

            chatInput.value = '';
            chatLog.scrollTop = chatLog.scrollHeight; // Auto-scroll to the latest message
        });

        function addMessage(sender, text, className) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `max-w-[70%] p-3 rounded-xl shadow-sm ${className}`;
            messageDiv.innerHTML = `<p>${text}</p>`;
            chatLog.appendChild(messageDiv);
        }
    </script>

</body>
</html>
