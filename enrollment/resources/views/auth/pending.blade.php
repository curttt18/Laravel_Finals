<x-guest-layout>
    <div class="auth-card" style="text-align: center; max-width: 500px;">
        <div style="margin-bottom: 24px;">
            <div style="width: 80px; height: 80px; background: var(--c-yellow); border: 3px solid var(--c-dark); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 4px 4px 0px var(--c-dark);">
                <i class="ri-time-line" style="font-size: 2.5rem; color: var(--c-dark);"></i>
            </div>
            <h1 style="font-family: 'Fredoka', sans-serif; font-size: 2rem; color: var(--c-dark); margin-bottom: 12px;">Account Pending Verification</h1>
            <p style="color: #64748b; line-height: 1.6; font-size: 1.05rem;">
                Thank you for registering! Your account is currently being reviewed by our admin team.
            </p>
        </div>

        <div style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
            <p style="color: #475569; font-weight: 600; margin-bottom: 8px;">
                <i class="ri-information-line" style="margin-right: 6px;"></i> What happens next?
            </p>
            <p style="color: #64748b; font-size: 0.95rem; line-height: 1.5;">
                Once verified, you'll be assigned the appropriate role and gain full access to your dashboard.
            </p>
        </div>

        <div style="background: #fef3c7; border: 2px solid #fcd34d; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
            <p style="color: #92400e; font-size: 0.9rem;">
                <i class="ri-timer-line" style="margin-right: 6px;"></i> This usually takes less than 24 hours.
            </p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary" style="width: 100%; justify-content: center;">
                <i class="ri-logout-box-line" style="margin-right: 8px;"></i> Sign Out
            </button>
        </form>
    </div>
</x-guest-layout>
