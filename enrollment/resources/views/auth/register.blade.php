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
                <div style="position: relative;">
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" style="padding-right: 45px;">
                    <button type="button" onclick="togglePassword('password', 'eyeIcon1')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 4px; color: #64748b;">
                        <i class="ri-eye-off-line" id="eyeIcon1" style="font-size: 1.2rem;"></i>
                    </button>
                </div>
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div style="position: relative;">
                    <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" style="padding-right: 45px;">
                    <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 4px; color: #64748b;">
                        <i class="ri-eye-off-line" id="eyeIcon2" style="font-size: 1.2rem;"></i>
                    </button>
                </div>
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

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
            } else {
                input.type = 'password';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            }
        }
    </script>
</x-guest-layout>
