@extends('layouts.student')

@section('content')
    <div class="welcome-header">
        <h1><i class="ri-hand-heart-line" style="color: var(--c-coral);"></i> Hello, {{ $student->student_name }}!</h1>
        <p>Here's an overview of your academic information.</p>
    </div>

    <div class="cards-grid">
        <!-- Student Info Card -->
        <div class="card">
            <div class="card-header">
                <i class="ri-user-heart-line"></i>
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
                <i class="ri-file-list-3-line"></i>
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
                <div class="empty-state">
                    <i class="ri-file-list-3-line"></i>
                    No enrollment records yet
                </div>
            @endforelse
        </div>

        <!-- Payments Card -->
        <div class="card">
            <div class="card-header">
                <i class="ri-bank-card-line" style="color: var(--success);"></i>
                <h3>Payment History</h3>
            </div>
            @forelse($payments as $payment)
                <div class="info-row">
                    <span class="info-label">
                        {{ $payment->fee->fee_name }}<br>
                        <small style="color: #94a3b8;">{{ $payment->payment_date->format('M d, Y') }}</small>
                    </span>
                    <span class="info-value amount">₱{{ number_format($payment->payment_amount, 2) }}</span>
                </div>
            @empty
                <div class="empty-state">
                    <i class="ri-bank-card-line"></i>
                    No payment records yet
                </div>
            @endforelse
        </div>

        <!-- Performance/Grades Card -->
        <div class="card">
            <div class="card-header">
                <i class="ri-award-line" style="color: var(--c-yellow);"></i>
                <h3>Academic Performance</h3>
            </div>
            @forelse($grades as $grade)
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span class="badge badge-info">{{ $grade->academic_period }}</span>
                        <small style="color: #94a3b8;">{{ $grade->teacher->teacher_name }}</small>
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
                        <div style="margin-top: 12px; padding: 12px; background: var(--bg-cream); border-radius: 8px; border: 1px solid var(--border);">
                            <small style="color: #64748b;"><strong>Remarks:</strong> {{ $grade->teacher_remarks }}</small>
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <i class="ri-award-line"></i>
                    No performance records yet
                </div>
            @endforelse
        </div>
    </div>
@endsection
