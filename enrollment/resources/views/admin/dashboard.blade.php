@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('breadcrumb', 'Admin / Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('admin.students.index') }}'">
            <div class="label">Total Students</div>
            <div class="value">{{ $totalStudents }}</div>
            <p class="change positive">View all</p>
        </div>
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('admin.enrollments.index') }}'">
            <div class="label">Enrolled</div>
            <div class="value">{{ $enrolledStudents }}</div>
            <p class="change positive">Active enrollments</p>
        </div>
        <div class="stat-card stat-card-clickable" id="pending-card" onclick="window.location.href='{{ route('admin.enrollments.index', ['status' => 'pending']) }}'">
            <div class="label">Pending</div>
            <div class="value" id="pending-count">{{ $pendingEnrollments }}</div>
            <p class="change {{ $pendingEnrollments > 0 ? 'negative' : 'positive' }}">
                @if($pendingEnrollments > 0)
                    Click to review
                @else
                    All caught up!
                @endif
            </p>
            @if($pendingEnrollments > 0)
            <div class="pending-preview">
                <div class="preview-title">Awaiting Approval</div>
                @foreach($pendingEnrollmentsList as $pending)
                <div class="preview-item">
                    <span class="preview-name">{{ $pending->student->student_name }}</span>
                    <span class="preview-date">{{ $pending->enrollment_date->format('M d') }}</span>
                </div>
                @endforeach
                @if($pendingEnrollments > 5)
                <div class="preview-more">+{{ $pendingEnrollments - 5 }} more...</div>
                @endif
            </div>
            @endif
        </div>
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('admin.teachers.index') }}'">
            <div class="label">Teachers</div>
            <div class="value">{{ $totalTeachers }}</div>
            <p class="change positive">View all</p>
        </div>
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('admin.payments.index') }}'">
            <div class="label">Total Payments</div>
            <div class="value">₱{{ number_format($totalPayments, 0) }}</div>
            <p class="change positive">All time</p>
        </div>
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('admin.users.index') }}'">
            <div class="label">System Users</div>
            <div class="value">{{ $totalUsers }}</div>
            <p class="change positive">View all</p>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 24px;">
        <!-- Recent Enrollments -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Enrollments</h3>
                <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary btn-sm">View All</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>School Year</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEnrollments as $enrollment)
                        <tr>
                            <td>{{ $enrollment->student->student_name }}</td>
                            <td>{{ $enrollment->school_year }}</td>
                            <td>
                                @if($enrollment->status === 'enrolled')
                                    <span class="badge badge-success">Enrolled</span>
                                @elseif($enrollment->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">{{ ucfirst($enrollment->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align: center; color: #9ca3af;">No recent enrollments</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Recent Payments -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Payments</h3>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">View All</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPayments as $payment)
                        <tr>
                            <td>{{ $payment->student->student_name }}</td>
                            <td style="color: #10b981; font-weight: 600;">₱{{ number_format($payment->payment_amount, 2) }}</td>
                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align: center; color: #9ca3af;">No recent payments</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card" style="margin-top: 24px;">
        <div class="card-header">
            <h3 class="card-title">Quick Actions</h3>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">+ Add Student</a>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-secondary">+ Add Teacher</a>
            <a href="{{ route('admin.enrollments.create') }}" class="btn btn-secondary">+ New Enrollment</a>
            <a href="{{ route('admin.payments.create') }}" class="btn btn-success">+ Record Payment</a>
        </div>
    </div>
@endsection
