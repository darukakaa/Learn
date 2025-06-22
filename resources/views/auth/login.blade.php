<x-guest-layout>
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-page {
            display: flex;
            align-items: center;
            background: #979797;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .login-card {
            display: flex;
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-left {
            flex: 1;
            background: #f0f4ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }

        .login-left img {
            max-width: 100%;
            height: auto;
            width: auto;
        }

        .login-left h2 {
            font-size: 1.5rem;
            color: #333;
            margin-top: 1rem;
        }

        .login-right {
            flex: 1;
            padding: 2.5rem;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #6b46c1;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icons a {
            font-size: 1.25rem;
            color: #555;
            transition: 0.3s ease;
        }

        .social-icons a:hover {
            color: #6b46c1;
        }
    </style>

    <div class="login-page">
        <div class="login-card">

            <!-- Left Image & Text -->
            <div class="login-left">
                <img src="{{ asset('storage/tes/1.jpg') }}" alt="Login Illustration">

            </div>

            <!-- Right Login Form -->
            <div class="login-right">
                <div class="form-title">Welcome</div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full rounded-md" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full rounded-md" type="password"
                            name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4 flex justify-between items-center">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember Login') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>

                    <!-- Social Logins -->
                    <div class="text-center mt-6">
                        <span class="text-sm text-gray-500">OR</span>
                        <div class="social-icons mt-2">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-google"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>

                    <!-- Sign Up -->
                    <div class="text-center mt-4 text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambahkan Font Awesome (untuk ikon medsos) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</x-guest-layout>
