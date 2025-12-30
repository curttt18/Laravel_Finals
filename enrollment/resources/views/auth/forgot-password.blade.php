<x-guest-layout>
    <div class="auth-card" style="max-width: 480px;">
        <!-- Header with Icon -->
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="width: 80px; height: 80px; background: var(--c-coral); border: 3px solid var(--c-dark); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 4px 4px 0px var(--c-dark);">
                <i class="ri-lock-unlock-line" style="font-size: 2.5rem; color: white;"></i>
            </div>
            <h1 style="font-family: 'Fredoka', sans-serif; font-size: 2rem; color: var(--c-dark); margin-bottom: 8px;">Forgot Password?</h1>
            <p style="color: #64748b; font-size: 1rem; line-height: 1.5;">
                No worries! Enter your email and we'll send you a reset link.
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div style="background: #d1fae5; border: 2px solid #10b981; border-radius: 12px; padding: 16px; margin-bottom: 24px; text-align: center;">
                <i class="ri-checkbox-circle-line" style="color: #10b981; margin-right: 8px;"></i>
                <span style="color: #065f46; font-weight: 600;">{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" style="display: flex; flex-direction: column; gap: 24px;">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="ri-mail-line" style="margin-right: 6px; color: var(--c-blue);"></i>Email Address
                </label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    class="form-input"
                    placeholder="your.email@example.com"
                    style="width: 100%; padding: 14px 16px; border: 3px solid var(--c-dark); border-radius: 12px; font-size: 1rem; transition: all 0.2s; background: white;"
                >
                @error('email')
                    <p style="color: #ef4444; font-size: 0.875rem; margin-top: 8px;">
                        <i class="ri-error-warning-line" style="margin-right: 4px;"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 16px 32px; font-size: 1.1rem;">
                <i class="ri-mail-send-line" style="margin-right: 8px;"></i>
                Send Reset Link
            </button>

            <!-- Back to Login -->
            <div style="text-align: center; margin-top: 16px;">
                <a href="{{ route('login') }}" style="color: var(--c-blue); font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
                    <i class="ri-arrow-left-line"></i>
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
