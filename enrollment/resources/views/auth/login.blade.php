<x-guest-layout>
    <div class="login-card">
        <div class="login-header">
            <span class="login-mascot">🧸</span>
            <h1 class="login-title">Welcome Back!</h1>
            <p class="login-subtitle">Login to your Little Stars account</p>
        </div>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@domain.com">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label"><span class="emoji">🔐</span> Password</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="remember-row">
                <label for="remember_me" class="remember-label">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="login-btn">Sign in</button>
            
            @if (Route::has('register'))
                <p class="register-link">
                    New here? <a href="{{ route('register') }}">Create an account</a>
                </p>
            @endif
        </form>
    </div>
</x-guest-layout>
