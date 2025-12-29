<x-guest-layout>
    <div class="login-card">
        <div class="login-header">
            <span class="login-mascot">🌟</span>
            <h1 class="login-title">Join Little Stars!</h1>
            <p class="login-subtitle">Create your account today</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Full name</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="First and last name">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@domain.com">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label"><span class="emoji">🔐</span> Password</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Create a password">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label"><span class="emoji">🔐</span> Confirm Password</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                @error('password_confirmation')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="login-btn">Create account</button>
            
            <p class="register-link">
                Already registered? <a href="{{ route('login') }}">Log in</a>
            </p>
        </form>
    </div>
</x-guest-layout>
