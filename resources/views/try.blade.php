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
            background-color: #1A4870;
            color: white;
            padding: 10px 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.5em;
        }

        header nav {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        header a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-size: 1em;
        }

        header a:hover {
            text-decoration: underline;
        }

        .main {
            padding: 20px;
            text-align: center;
        }

        .main h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .main p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .btn-join {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
        }

        .btn-join:hover {
            background-color: #45a049;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 5px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 0.9em;
        }

        /* Media queries for responsive design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 1.2em;
            }

            header nav {
                flex-direction: column;
                align-items: flex-start;
            }

            header a {
                margin: 5px 0;
            }

            .main h1 {
                font-size: 1.5em;
            }

            .main p {
                font-size: 1em;
            }

            .btn-join {
                font-size: 1em;
                padding: 8px 16px;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 1em;
            }

            header nav {
                flex-direction: column;
                align-items: flex-start;
            }

            header a {
                margin: 5px 0;
                font-size: 0.9em;
            }

            .main h1 {
                font-size: 1.2em;
            }

            .main p {
                font-size: 0.9em;
            }

            .btn-join {
                font-size: 0.9em;
                padding: 6px 12px;
            }

            footer {
                padding: 3px 0;
                font-size: 0.8em;
            }
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
