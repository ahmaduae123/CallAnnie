<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chatbot - Home</title>
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
        header {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #ffcc00;
        }
        .hero {
            text-align: center;
            padding: 50px 20px;
            flex-grow: 1;
        }
        .hero h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2em;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        .btn {
            background: #ffcc00;
            color: #000;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #e6b800;
        }
        footer {
            background: rgba(0, 0, 0, 0.7);
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        @media (max-width: 768px) {
            header h1 {
                font-size: 1.8em;
            }
            .hero h2 {
                font-size: 1.5em;
            }
            .hero p {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>AI Chatbot</h1>
        <nav>
            <a href="javascript:redirectTo('signup.php')">Sign Up</a>
            <a href="javascript:redirectTo('login.php')">Login</a>
            <a href="javascript:redirectTo('chat.php')">Chat Now</a>
        </nav>
    </header>
    <div class="hero">
        <h2>Welcome to Your AI Companion</h2>
        <p>Interact with our intelligent chatbot through voice or text. Get instant responses, personalized assistance, and seamless conversations anytime, anywhere.</p>
        <a href="javascript:redirectTo('chat.php')" class="btn">Start Chatting</a>
    </div>
    <footer>
        <p>&copy; 2025 AI Chatbot. All rights reserved.</p>
    </footer>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
