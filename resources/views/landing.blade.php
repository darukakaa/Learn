<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learnify</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
        }

        header nav {
            display: flex;
            align-items: center;
        }

        header a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        header a:hover {
            text-decoration: underline;
        }

        .main {
            padding: 50px;
            text-align: center;
        }

        .main h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .main p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .btn-join {
            background-color: #4CAF50;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
        }

        .btn-join:hover {
            background-color: #45a049;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Learnify</h1>
        <nav>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <div class="main">
        <h1>Welcome to Learnify</h1>
        <p>Empower your learning journey with us. Join now to get started!</p>
        <a href="{{ route('register') }}" class="btn-join">Join Now</a>
    </div>

    <footer>
        <p>Learnify 2024</p>
    </footer>
</body>
</html>
