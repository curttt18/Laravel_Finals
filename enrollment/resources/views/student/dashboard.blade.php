@extends('layouts.student')

@section('content')
    <div class="welcome-header">
        <h1><i class="ri-hand-heart-line" style="color: var(--c-coral);"></i> Hello, {{ $student->student_name }}!</h1>
        <p>Here's an overview of your academic information.</p>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="stat-item">
            <i class="ri-file-list-3-line"></i>
            <div class="stat-content">
                <span class="stat-value">{{ $enrollments->count() }}</span>
                <span class="stat-label">Enrollments</span>
            </div>
        </div>
        <div class="stat-item">
            <i class="ri-bank-card-line" style="color: var(--success);"></i>
            <div class="stat-content">
                <span class="stat-value">₱{{ number_format($payments->sum('payment_amount'), 0) }}</span>
                <span class="stat-label">Total Paid</span>
            </div>
        </div>
        <div class="stat-item">
            <i class="ri-award-line" style="color: var(--c-yellow);"></i>
            <div class="stat-content">
                <span class="stat-value">{{ $grades->count() }}</span>
                <span class="stat-label">Grade Records</span>
            </div>
        </div>
        <div class="stat-item">
            <i class="ri-calendar-check-line" style="color: var(--c-blue);"></i>
            <div class="stat-content">
                <span class="stat-value">{{ $enrollments->where('status', 'enrolled')->count() > 0 ? 'Active' : 'Inactive' }}</span>
                <span class="stat-label">Status</span>
            </div>
        </div>
    </div>

    <!-- Main Grid: 2 columns -->
    <div class="main-grid">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Student Info Card -->
            <div class="card">
                <div class="card-header">
                    <i class="ri-user-heart-line"></i>
                    <h3>My Information</h3>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Student ID</span>
                        <span class="info-value">#{{ $student->student_id }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">{{ $student->date_of_birth->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Gender</span>
                        <span class="info-value">{{ ucfirst($student->gender) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Guardian</span>
                        <span class="info-value">{{ $student->guardian_name }}</span>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label">Contact</span>
                        <span class="info-value">{{ $student->contact_information }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="right-column">
            <!-- Enrollment Status Card -->
            <div class="card">
                <div class="card-header">
                    <i class="ri-file-list-3-line"></i>
                    <h3>My Enrollments</h3>
                </div>
                @forelse($enrollments as $enrollment)
                    <div class="enrollment-item">
                        <div class="enrollment-info">
                            <span class="school-year">{{ $enrollment->school_year }}</span>
                            <span class="enrollment-date">{{ $enrollment->enrollment_date->format('M d, Y') }}</span>
                        </div>
                        @if($enrollment->status === 'enrolled')
                            <span class="badge badge-success">Enrolled</span>
                        @elseif($enrollment->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-info">{{ ucfirst($enrollment->status) }}</span>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="ri-file-list-3-line"></i>
                        No enrollment records yet
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Full Width Section: Payments & Grades -->
    <div class="full-width-section">
        <!-- Payments Card -->
        <div class="card">
            <div class="card-header">
                <i class="ri-bank-card-line" style="color: var(--success);"></i>
                <h3>Payment History</h3>
                <span class="card-badge">{{ $payments->count() }} records</span>
            </div>
            @if($payments->count() > 0)
                <div class="payments-table">
                    <div class="table-header">
                        <span>Fee</span>
                        <span>Date</span>
                        <span>Type</span>
                        <span>Amount</span>
                    </div>
                    @foreach($payments as $payment)
                        <div class="table-row">
                            <span class="fee-name">{{ $payment->fee->fee_name }}</span>
                            <span class="fee-date">{{ $payment->payment_date->format('M d, Y') }}</span>
                            <span><span class="badge badge-{{ $payment->payment_type === 'full' ? 'success' : 'info' }}">{{ ucfirst($payment->payment_type) }}</span></span>
                            <span class="amount">₱{{ number_format($payment->payment_amount, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="ri-bank-card-line"></i>
                    No payment records yet
                </div>
            @endif
        </div>

        <!-- Performance/Grades Card -->
        <div class="card">
            <div class="card-header">
                <i class="ri-award-line" style="color: var(--c-yellow);"></i>
                <h3>Academic Performance</h3>
                <span class="card-badge">{{ $grades->count() }} reports</span>
            </div>
            @forelse($grades as $grade)
                <div class="grade-card">
                    <div class="grade-header">
                        <div class="grade-period">
                            <span class="badge badge-info">{{ $grade->academic_period }}</span>
                            <span class="teacher-name">{{ $grade->teacher->teacher_name }}</span>
                        </div>
                    </div>
                    <div class="skills-grid">
                        <div class="skill-item {{ strtolower($grade->cognitive_skills) }}">
                            <span class="skill-label">Cognitive</span>
                            <span class="skill-value">{{ ucfirst(str_replace('_', ' ', $grade->cognitive_skills)) }}</span>
                        </div>
                        <div class="skill-item {{ strtolower($grade->motor_skills) }}">
                            <span class="skill-label">Motor</span>
                            <span class="skill-value">{{ ucfirst(str_replace('_', ' ', $grade->motor_skills)) }}</span>
                        </div>
                        <div class="skill-item {{ strtolower($grade->social_skills) }}">
                            <span class="skill-label">Social</span>
                            <span class="skill-value">{{ ucfirst(str_replace('_', ' ', $grade->social_skills)) }}</span>
                        </div>
                        <div class="skill-item {{ strtolower($grade->emotional_dev) }}">
                            <span class="skill-label">Emotional</span>
                            <span class="skill-value">{{ ucfirst(str_replace('_', ' ', $grade->emotional_dev)) }}</span>
                        </div>
                        <div class="skill-item {{ strtolower($grade->behavior) }}">
                            <span class="skill-label">Behavior</span>
                            <span class="skill-value">{{ ucfirst(str_replace('_', ' ', $grade->behavior)) }}</span>
                        </div>
                    </div>
                    @if($grade->teacher_remarks)
                        <div class="remarks">
                            <strong>Remarks:</strong> {{ $grade->teacher_remarks }}
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
