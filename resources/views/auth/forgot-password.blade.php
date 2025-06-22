<x-guest-layout>
    <style>
        .forgot-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
            background-color: #f9fafb;
            font-family: 'Segoe UI', sans-serif;
        }

        .forgot-card {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #6b46c1;
            /* ungu */
        }

        .form-subtext {
            font-size: 0.95rem;
            color: #4b5563;
            /* abu-abu */
            margin-bottom: 1.5rem;
            text-align: center;
        }
    </style>

    <div class="forgot-page">
        <div class="forgot-card">
            <div class="form-title">Lupa Password?</div>

            <div class="form-subtext">
                {{ __('Tidak masalah. Masukkan email kamu dan kami akan kirim tautan reset password.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('fake.password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-primary-button class="w-full justify-center">
                        {{ __('Kirim Link Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
