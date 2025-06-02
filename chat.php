<?php
session_start();
require_once 'db.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    error_log("Received message: $message", 3, 'debug.log'); // Log input
    $response = getAIResponse($message);
    error_log("Response: $response", 3, 'debug.log'); // Log response
    if ($user_id) {
        try {
            $stmt = $conn->prepare("INSERT INTO messages (user_id, message, response) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $message, $response);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            error_log("Database error: " . $e->getMessage(), 3, 'debug.log');
        }
    }
}

function getAIResponse($message) {
    $message = strtolower(trim($message));
    
    // Advanced mock AI with pattern matching
    if (preg_match('/^(hello|hi|hey|yo|greetings)(\s|$)/', $message)) {
        return "Hey there! How can I assist you today?";
    }
    if (preg_match('/how\s+are\s+you/', $message)) {
        return "I'm doing awesome, thanks for asking! What's up with you?";
    }
    if (preg_match('/(bye|goodbye|see\s+you|later)/', $message)) {
        return "Catch you later! Have a great day!";
    }
    if (preg_match('/(what\s+is\s+ai|tell\s+me\s+about\s+ai|artificial\s+intelligence)/', $message)) {
        return "AI is like a super-smart brain for computers, letting them learn, think, and solve problems. I'm an example! Want to dive deeper?";
    }
    if (preg_match('/(joke|tell\s+me\s+a\s+joke|something\s+funny)/', $message)) {
        $jokes = [
            "Why did the computer go to art school? Because it wanted to draw a better 'byte'!",
            "Why don't programmers prefer dark mode? Because the light attracts bugs.",
            "What do you call a dinosaur that codes? A Code-a-saurus Rex!"
        ];
        return $jokes[array_rand($jokes)];
    }
    if (preg_match('/(weather|what\'s\s+the\s+weather)/', $message)) {
        return "I don't have live weather data, but I bet it's sunny where you are! What's the vibe today?";
    }
    if (preg_match('/(who\s+are\s+you|what\s+are\s+you)/', $message)) {
        return "I'm your friendly AI chatbot, inspired by Call Annie, built to answer questions and have fun! What's on your mind?";
    }
    if (preg_match('/(help|what\s+can\s+you\s+do)/', $message)) {
        return "I can chat about AI, tell jokes, answer questions, or just vibe with you! Try asking 'What is AI?', 'Tell me a joke', or anything else!";
    }
    if (preg_match('/(thanks|thank\s+you)/', $message)) {
        return "You're welcome! Happy to help anytime.";
    }
    if (preg_match('/(how\s+to|explain|what\s+is)\s+(.+)/', $message, $matches)) {
        return "Hmm, you want to know about '{$matches[2]}'? Can you give me a bit more detail, and I'll break it down for you!";
    }
    if (preg_match('/(hi\s+there|good\s+morning|good\s+evening)/', $message)) {
        return "Yo, what's good? Ready to chat?";
    }
    
    // Fallback for unmatched inputs
    return "I'm not sure I got that. Could you rephrase or try something like 'What is AI?' or 'Tell me a joke'?";
}

$messages = [];
if ($user_id) {
    try {
        $stmt = $conn->prepare("SELECT message, response, created_at FROM messages WHERE user_id = ? ORDER BY created_at");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log("Database query error: " . $e->getMessage(), 3, 'debug.log');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with AI</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .chat-container {
            max-width: 800px;
            margin: 20px auto;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            padding: 20px;
            flex-grow: 1;
        }
        .chat-box {
            height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .message {
            margin: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .user-message {
            background: #ffcc00;
            color: #000;
            margin-left: 20%;
        }
        .bot-message {
            background: #fff;
            color: #000;
            margin-right: 20%;
        }
        .input-container {
            display: flex;
            gap: 10px;
        }
        input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
        }
        button {
            background: #ffcc00;
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #e6b800;
        }
        .voice-btn {
            background: #00ccff;
        }
        .voice-btn:hover {
            background: #00b3e6;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            color: #ffcc00;
            text-decoration: none;
        }
        .logout a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .chat-container {
                margin: 10px;
                padding: 15px;
            }
            .chat-box {
                height: 300px;
            }
            .message {
                margin: 5px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h2>Chat with AI</h2>
        <div class="chat-box" id="chatBox">
            <?php foreach ($messages as $msg): ?>
                <div class="message user-message"><?php echo htmlspecialchars($msg['message']); ?> <small>(<?php echo $msg['created_at']; ?>)</small></div>
                <div class="message bot-message"><?php echo htmlspecialchars($msg['response']); ?> <small>(<?php echo $msg['created_at']; ?>)</small></div>
            <?php endforeach; ?>
        </div>
        <form method="POST" id="chatForm">
            <div class="input-container">
                <input type="text" name="message" id="messageInput" placeholder="Type your message..." required>
                <button type="submit">Send</button>
                <button type="button" class="voice-btn" id="voiceBtn">Voice</button>
            </div>
        </form>
        <?php if ($user_id): ?>
            <div class="logout">
                <a href="javascript:redirectTo('logout.php')">Logout</a>
            </div>
        <?php else: ?>
            <div class="logout">
                <a href="javascript:redirectTo('login.php')">Login to save chat history</a>
            </div>
        <?php endif; ?>
    </div>
    <script>
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = 'en-US';
        recognition.interimResults = false;

        document.getElementById('voiceBtn').addEventListener('click', () => {
            recognition.start();
        });

        recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            document.getElementById('messageInput').value = transcript;
            document.getElementById('chatForm').submit();
        };

        recognition.onerror = (event) => {
            console.error('Speech recognition error:', event.error);
        };

        function redirectTo(page) {
            window.location.href = page;
        }

        // Auto-scroll chat box
        const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</body>
</html>
