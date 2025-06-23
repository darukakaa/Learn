<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Landing Page</title>
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #000;
            color: #eee;
            overflow-x: hidden;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            background: rgba(0, 0, 0, 0.7);
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        header a {
            color: #eee;
            text-decoration: none;
            margin-left: 30px;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        header a:hover {
            color: #d4af37;
            /* warna emas */
        }

        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: url('https://cdn.pagani.com/wp-content/uploads/2023/02/Utopia_C_22_034-1-1920x1080.jpg') center/cover no-repeat;
            text-align: center;
            padding: 0 20px;
            position: relative;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            color: #d4af37;
            text-shadow: 0 0 15px rgba(212, 175, 55, 0.7);
        }

        .hero-content h1 {
            font-size: 4rem;
            font-weight: 900;
            letter-spacing: 5px;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 1.4rem;
            margin-bottom: 40px;
            font-weight: 300;
        }

        .btn-primary {
            background: #d4af37;
            border: none;
            padding: 15px 40px;
            font-weight: 700;
            color: #111;
            font-size: 1.1rem;
            cursor: pointer;
            text-transform: uppercase;
            border-radius: 50px;
            box-shadow: 0 0 10px #d4af37;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .btn-primary:hover {
            background: #fff;
            box-shadow: 0 0 20px #fff;
        }

        section.features {
            background: transparent;
            padding: 60px 20px;
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .feature {
            max-width: 300px;
            text-align: center;
            color: #eee;
            font-weight: 300;
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s ease, transform 0.8s ease;
            will-change: opacity, transform;
        }

        .feature.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .feature img {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.7);
            margin-bottom: 20px;
            transition: transform 0.4s ease;
        }

        .feature img:hover {
            transform: scale(1.05);
        }

        .feature h3 {
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #d4af37;
        }

        .feature p {
            font-size: 1rem;
            line-height: 1.5;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            background: rgba(0, 0, 0, 0.7);
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .logo img {
            height: 50px;
            width: auto;
            display: block;
        }



        footer {
            text-align: center;
            padding: 20px;
            background: #000;
            font-size: 0.9rem;
            color: #777;
            border-top: 1px solid #222;
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.8rem;
            }

            .feature {
                max-width: 90%;
            }
        }
    </style>
</head>

<body>


    <div class="background-container">
        <div class="bg-layer bg1"></div>
        <div class="bg-layer bg2"></div>
    </div>

    <header>
        <div class="logo">
            <img src="{{ asset('storage/logo/erasebg-transformedd.png') }}" alt="Logo" class="h-10 w-auto">
        </div>

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

    <section class="hero">
        <div class="hero-content">
            <h1>LEARNIFY</h1>
            <p>Empower your learning journey with us. Join now to get started!</p>
            <a href="{{ route('login') }}">
                <button class="btn-primary">Join Now</button>
            </a>
        </div>
    </section>

    <section class="features">
        <div class="feature">
            <img src="{{ asset('storage/tes/1.jpg') }}" alt="Zonda" />
            <h3>ZONDA</h3>
            <p>Ikon hypercar legendaris yang memadukan performa dan desain tak tertandingi.</p>
        </div>
        <div class="feature">
            <img src="{{ asset('storage/tes/1.jpg') }}" alt="Hyura" />

            <h3>HUAYRA</h3>
            <p>Perpaduan teknologi tinggi dan estetika futuristik dalam satu mobil.</p>
        </div>
        <div class="feature">
            <img src="{{ asset('storage/tes/1.jpg') }}" alt="Utopia" />

            <h3>UTOPIA</h3>
            <p>Model terbaru yang melambangkan era baru hypercar Italia.</p>
        </div>
    </section>

    <footer>
        &copy; Learnify 2024.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const features = document.querySelectorAll('.feature');

            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.2
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            features.forEach(feature => observer.observe(feature));

            // Background scroll animation
            const bg1 = document.querySelector('.bg1');
            const bg2 = document.querySelector('.bg2');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 10) {
                    bg1.style.opacity = '0';
                    bg2.style.opacity = '1';
                } else {
                    bg1.style.opacity = '1';
                    bg2.style.opacity = '0';
                }
            });

        });
    </script>

    <style>
        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .bg-layer {
            position: absolute;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            transition: opacity 1.2s ease-in-out;
            will-change: opacity;
        }

        .bg1 {
            background-image: url('{{ asset('storage/land/land1.png') }}');
            opacity: 1;
        }

        .bg2 {
            background-image: url('{{ asset('storage/land/land2.png') }}');
            opacity: 0;
        }
    </style>

</body>


</html>
