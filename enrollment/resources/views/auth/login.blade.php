<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="ri-shining-2-fill"></i> Little Stars
            </div>
            <h1 class="auth-title">Welcome Back!</h1>
            <p class="auth-subtitle">Login to your Little Stars account</p>
        </div>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div style="position: relative;">
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" style="padding-right: 45px;">
                    <button type="button" id="togglePassword" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 4px; color: #64748b;">
                        <i class="ri-eye-off-line" id="eyeIcon" style="font-size: 1.2rem;"></i>
                    </button>
                </div>
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot -->
            <div class="options-row">
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

            <button type="submit" class="btn btn-primary">
                <i class="ri-login-box-fill" style="margin-right: 8px;"></i> Sign In
            </button>
            
            @if (Route::has('register'))
                <p class="auth-footer">
                    New here? <a href="{{ route('register') }}">Create an account</a>
                </p>
            @endif
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('ri-eye-off-line');
                eyeIcon.classList.add('ri-eye-line');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('ri-eye-line');
                eyeIcon.classList.add('ri-eye-off-line');
            }
        });
    </script>
</x-guest-layout>
