@extends('layouts.student')

@section('content')
    <div class="welcome-header">
        <h1>Hello, {{ $student->student_name }}!</h1>
        <p>Here's an overview of your academic information.</p>
    </div>

    <div class="cards-grid">
        <!-- Student Info Card -->
        <div class="card">
            <div class="card-header">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <h3>My Information</h3>
            </div>
            <div class="info-row">
                <span class="info-label">Student ID</span>
                <span class="info-value">#{{ $student->student_id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date of Birth</span>
                <span class="info-value">{{ $student->date_of_birth->format('F d, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Gender</span>
                <span class="info-value">{{ ucfirst($student->gender) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Guardian</span>
                <span class="info-value">{{ $student->guardian_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Contact</span>
                <span class="info-value">{{ $student->contact_information }}</span>
            </div>
        </div>

        <!-- Enrollment Status Card -->
        <div class="card">
            <div class="card-header">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <h3>My Enrollments</h3>
            </div>
            @forelse($enrollments as $enrollment)
                <div class="info-row">
                    <span class="info-label">{{ $enrollment->school_year }}</span>
                    <span class="info-value">
                        @if($enrollment->status === 'enrolled')
                            <span class="badge badge-success">Enrolled</span>
                        @elseif($enrollment->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-info">{{ ucfirst($enrollment->status) }}</span>
                        @endif
                    </span>
                </div>
            @empty
                <div class="empty-state">No enrollment records yet</div>
            @endforelse
        </div>

        <!-- Payments Card -->
        <div class="card">
            <div class="card-header">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <h3>Payment History</h3>
            </div>
            @forelse($payments as $payment)
                <div class="info-row">
                    <span class="info-label">
                        {{ $payment->fee->fee_name }}<br>
                        <small>{{ $payment->payment_date->format('M d, Y') }}</small>
                    </span>
                    <span class="info-value amount">₱{{ number_format($payment->payment_amount, 2) }}</span>
                </div>
            @empty
                <div class="empty-state">No payment records yet</div>
            @endforelse
        </div>

        <!-- Performance/Grades Card -->
        <div class="card">
            <div class="card-header">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <h3>Academic Performance</h3>
            </div>
            @forelse($grades as $grade)
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <strong style="color: var(--primary);">{{ $grade->academic_period }}</strong>
                        <small style="color: #9ca3af;">{{ $grade->teacher->teacher_name }}</small>
                    </div>
                    <div class="grade-grid">
                        <div class="grade-item">
                            <div class="label">Cognitive</div>
                            <div class="value">{{ str_replace('_', ' ', $grade->cognitive_skills) }}</div>
                        </div>
                        <div class="grade-item">
                            <div class="label">Motor</div>
                            <div class="value">{{ str_replace('_', ' ', $grade->motor_skills) }}</div>
                        </div>
                        <div class="grade-item">
                            <div class="label">Social</div>
                            <div class="value">{{ str_replace('_', ' ', $grade->social_skills) }}</div>
                        </div>
                        <div class="grade-item">
                            <div class="label">Emotional</div>
                            <div class="value">{{ str_replace('_', ' ', $grade->emotional_dev) }}</div>
                        </div>
                        <div class="grade-item">
                            <div class="label">Behavior</div>
                            <div class="value">{{ str_replace('_', ' ', $grade->behavior) }}</div>
                        </div>
                    </div>
                    @if($grade->teacher_remarks)
                        <div style="margin-top: 12px; padding: 12px; background: #f9fafb; border-radius: 6px;">
                            <small style="color: #6b7280;"><strong>Remarks:</strong> {{ $grade->teacher_remarks }}</small>
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">No performance records yet</div>
            @endforelse
        </div>
    </div>
@endsection
