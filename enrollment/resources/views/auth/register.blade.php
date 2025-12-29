<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="ri-shining-2-fill"></i> Little Stars
            </div>
            <h1 class="auth-title">Join Little Stars!</h1>
            <p class="auth-subtitle">Create your account today</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="First and last name">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Create a password">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                @error('password_confirmation')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="ri-user-add-fill" style="margin-right: 8px;"></i> Create Account
            </button>
            
            <p class="auth-footer">
                Already registered? <a href="{{ route('login') }}">Log in</a>
            </p>
        </form>
    </div>
</x-guest-layout>
