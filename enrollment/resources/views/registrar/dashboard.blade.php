@extends('layouts.registrar')

@section('page-title', 'Dashboard')
@section('breadcrumb', 'Registrar / Dashboard')

@section('content')
    <div class="stats-grid">
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('registrar.students.index') }}'">
            <div class="label">Total Students</div>
            <div class="value">{{ $totalStudents }}</div>
            <p class="change positive">View all</p>
        </div>
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('registrar.enrollments.index') }}'">
            <div class="label">Enrolled</div>
            <div class="value">{{ $enrolledStudents }}</div>
            <p class="change positive">View all</p>
        </div>
        <div class="stat-card stat-card-clickable" id="pending-card" onclick="window.location.href='{{ route('registrar.enrollments.index', ['status' => 'pending']) }}'">
            <div class="label">Pending Enrollments</div>
            <div class="value" id="pending-count">{{ $pendingEnrollments }}</div>
            @if($pendingEnrollments > 0)
            <p class="change negative">Click to review</p>
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
            @else
            <p class="change positive">All caught up!</p>
            @endif
        </div>
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('registrar.teachers.index') }}'">
            <div class="label">Teachers</div>
            <div class="value">{{ $totalTeachers }}</div>
            <p class="change positive">View all</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <!-- Pending Enrollments -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="ri-file-list-3-line" style="margin-right: 8px; color: var(--primary);"></i>Pending Approvals</h3>
                <a href="{{ route('registrar.enrollments.index') }}" class="btn btn-sm btn-secondary">View All</a>
            </div>
            
            @forelse($recentEnrollments->where('status', 'pending') as $enrollment)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 0; {{ !$loop->last ? 'border-bottom: 1px solid var(--border);' : '' }}">
                    <div>
                        <div style="font-weight: 600; color: var(--c-dark);">{{ $enrollment->student->student_name }}</div>
                        <div style="font-size: 0.85rem; color: #64748b;">{{ $enrollment->school_year }} - {{ $enrollment->enrollment_date->format('M d, Y') }}</div>
                    </div>
                    <form action="{{ route('registrar.enrollments.approve', $enrollment) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="ri-check-line"></i> Approve
                        </button>
                    </form>
                </div>
            @empty
                <div style="text-align: center; padding: 32px; color: #94a3b8;">
                    <i class="ri-checkbox-circle-line" style="font-size: 2rem; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                    No pending enrollments
                </div>
            @endforelse
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="ri-flashlight-line" style="margin-right: 8px; color: var(--c-coral);"></i>Quick Actions</h3>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <a href="{{ route('registrar.students.create') }}" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 18px; background: #dbeafe; color: #1e40af; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                    <i class="ri-user-add-line" style="font-size: 1.3rem;"></i>
                    Add Student
                </a>
                <a href="{{ route('registrar.enrollments.create') }}" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 18px; background: #d1fae5; color: #065f46; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                    <i class="ri-file-add-line" style="font-size: 1.3rem;"></i>
                    New Enrollment
                </a>
                <a href="{{ route('registrar.teachers.create') }}" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 18px; background: #fae8ff; color: #86198f; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                    <i class="ri-user-star-line" style="font-size: 1.3rem;"></i>
                    Add Teacher
                </a>
                <a href="{{ route('registrar.grades.create') }}" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 18px; background: #fef3c7; color: #92400e; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                    <i class="ri-award-line" style="font-size: 1.3rem;"></i>
                    Add Grade
                </a>
            </div>
        </div>
    </div>
@endsection
