@extends('layouts.admin')

@section('page-title', 'Student Details')
@section('breadcrumb', 'Admin / Students / View')

@section('page-actions')
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary">
            <i class="ri-pencil-line"></i> Edit Student
        </a>
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
            <i class="ri-arrow-left-line"></i> Back
        </a>
    </div>
@endsection

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px;">
        
        <!-- Student Info Card -->
        <div class="card">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                <div style="width: 72px; height: 72px; background: var(--c-coral); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.8rem; font-weight: 700; font-family: 'Fredoka', sans-serif;">
                    {{ substr($student->student_name, 0, 1) }}
                </div>
                <div>
                    <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--c-dark); margin-bottom: 4px;">{{ $student->student_name }}</h3>
                    <p style="color: #64748b; font-size: 0.9rem;">Student ID: #{{ $student->student_id }}</p>
                </div>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                    <span style="color: #64748b; font-weight: 500;"><i class="ri-cake-2-line" style="margin-right: 8px;"></i>Date of Birth</span>
                    <span style="font-weight: 600;">{{ $student->date_of_birth->format('M d, Y') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                    <span style="color: #64748b; font-weight: 500;"><i class="ri-user-line" style="margin-right: 8px;"></i>Gender</span>
                    @if($student->gender === 'male')
                        <span class="badge badge-info">Male</span>
                    @else
                        <span class="badge" style="background: #fce7f3; color: #be185d;">Female</span>
                    @endif
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                    <span style="color: #64748b; font-weight: 500;"><i class="ri-phone-line" style="margin-right: 8px;"></i>Contact</span>
                    <span style="font-weight: 600;">{{ $student->contact_information }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                    <span style="color: #64748b; font-weight: 500;"><i class="ri-parent-line" style="margin-right: 8px;"></i>Guardian</span>
                    <span style="font-weight: 600;">{{ $student->guardian_name }}</span>
                </div>
                <div style="padding: 12px 0;">
                    <span style="color: #64748b; font-weight: 500; display: block; margin-bottom: 8px;"><i class="ri-map-pin-line" style="margin-right: 8px;"></i>Address</span>
                    <p style="font-weight: 500; color: var(--c-dark); line-height: 1.5;">{{ $student->address }}</p>
                </div>
            </div>
        </div>

        <!-- Enrollments Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="ri-file-list-3-line" style="margin-right: 8px; color: var(--c-blue);"></i>Enrollments</h3>
            </div>
            @forelse($student->enrollments as $enrollment)
                <div style="padding: 16px 0; border-bottom: 1px solid var(--border); {{ $loop->last ? 'border-bottom: none;' : '' }}">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="font-weight: 600; color: var(--c-dark);">{{ $enrollment->school_year }}</span>
                        @if($enrollment->status === 'enrolled')
                            <span class="badge badge-success">Enrolled</span>
                        @elseif($enrollment->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">{{ ucfirst($enrollment->status) }}</span>
                        @endif
                    </div>
                    <p style="font-size: 0.85rem; color: #64748b;">{{ $enrollment->enrollment_date->format('M d, Y') }}</p>
                </div>
            @empty
                <div style="text-align: center; padding: 32px; color: #94a3b8;">
                    <i class="ri-file-list-3-line" style="font-size: 2rem; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                    No enrollments yet
                </div>
            @endforelse
        </div>

        <!-- Payments Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="ri-bank-card-line" style="margin-right: 8px; color: var(--success);"></i>Payments</h3>
            </div>
            @forelse($student->payments as $payment)
                <div style="padding: 16px 0; border-bottom: 1px solid var(--border); {{ $loop->last ? 'border-bottom: none;' : '' }}">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="font-weight: 600; color: var(--c-dark);">{{ $payment->fee->fee_name }}</span>
                        <span style="color: var(--success); font-weight: 700;">₱{{ number_format($payment->payment_amount, 2) }}</span>
                    </div>
                    <p style="font-size: 0.85rem; color: #64748b;">{{ $payment->payment_date->format('M d, Y') }}</p>
                </div>
            @empty
                <div style="text-align: center; padding: 32px; color: #94a3b8;">
                    <i class="ri-bank-card-line" style="font-size: 2rem; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                    No payments yet
                </div>
            @endforelse
        </div>
    </div>

    <!-- Performance Records (Grades) -->
    <div class="card" style="margin-top: 24px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-award-line" style="margin-right: 8px; color: var(--c-coral);"></i>Performance Records</h3>
        </div>
        
        @forelse($student->grades as $grade)
            <div style="background: var(--bg-cream); border-radius: 12px; padding: 20px; margin-bottom: 16px; border: 1px solid var(--border); {{ $loop->last ? 'margin-bottom: 0;' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <span style="font-size: 1.1rem; font-weight: 700; color: var(--c-dark);">{{ $grade->academic_period }}</span>
                    <span style="font-size: 0.85rem; color: #64748b;"><i class="ri-user-star-line" style="margin-right: 4px;"></i>{{ $grade->teacher->teacher_name }}</span>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; text-align: center;">
                    <div style="background: white; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 4px;">Cognitive</p>
                        <p style="font-weight: 600; color: var(--c-dark); text-transform: capitalize;">{{ str_replace('_', ' ', $grade->cognitive_skills) }}</p>
                    </div>
                    <div style="background: white; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 4px;">Motor</p>
                        <p style="font-weight: 600; color: var(--c-dark); text-transform: capitalize;">{{ str_replace('_', ' ', $grade->motor_skills) }}</p>
                    </div>
                    <div style="background: white; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 4px;">Social</p>
                        <p style="font-weight: 600; color: var(--c-dark); text-transform: capitalize;">{{ str_replace('_', ' ', $grade->social_skills) }}</p>
                    </div>
                    <div style="background: white; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 4px;">Emotional</p>
                        <p style="font-weight: 600; color: var(--c-dark); text-transform: capitalize;">{{ str_replace('_', ' ', $grade->emotional_dev) }}</p>
                    </div>
                    <div style="background: white; padding: 12px; border-radius: 10px; border: 1px solid var(--border);">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 4px;">Behavior</p>
                        <p style="font-weight: 600; color: var(--c-dark); text-transform: capitalize;">{{ str_replace('_', ' ', $grade->behavior) }}</p>
                    </div>
                </div>
                
                @if($grade->teacher_remarks)
                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px dashed var(--border);">
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 4px;"><i class="ri-chat-quote-line" style="margin-right: 4px;"></i>Teacher Remarks:</p>
                        <p style="font-size: 0.9rem; color: var(--c-dark); line-height: 1.5;">{{ $grade->teacher_remarks }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div style="text-align: center; padding: 48px; color: #94a3b8;">
                <i class="ri-award-line" style="font-size: 3rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                No performance records yet
            </div>
        @endforelse
    </div>
@endsection
