@extends('layouts.admin')

@section('page-title', 'Student Details')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.students.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Students</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Student Info Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr($student->student_name, 0, 1) }}
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ $student->student_name }}</h3>
                    <p class="text-gray-500">ID: {{ $student->student_id }}</p>
                </div>
            </div>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Date of Birth:</span>
                    <span class="font-medium">{{ $student->date_of_birth->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Gender:</span>
                    <span class="font-medium">{{ ucfirst($student->gender) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Contact:</span>
                    <span class="font-medium">{{ $student->contact_information }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Guardian:</span>
                    <span class="font-medium">{{ $student->guardian_name }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Address:</span>
                    <p class="font-medium mt-1">{{ $student->address }}</p>
                </div>
            </div>

            <div class="mt-6 flex space-x-2">
                <a href="{{ route('admin.students.edit', $student) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Edit</a>
            </div>
        </div>

        <!-- Enrollments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold mb-4">Enrollments</h4>
            @forelse($student->enrollments as $enrollment)
                <div class="border-b border-gray-100 py-3 {{ $loop->last ? 'border-b-0' : '' }}">
                    <div class="flex justify-between items-center">
                        <span class="font-medium">{{ $enrollment->school_year }}</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                            {{ $enrollment->status === 'enrolled' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $enrollment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $enrollment->status === 'withdrawn' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">{{ $enrollment->enrollment_date->format('M d, Y') }}</p>
                </div>
            @empty
                <p class="text-gray-500">No enrollments yet</p>
            @endforelse
        </div>

        <!-- Payments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold mb-4">Payments</h4>
            @forelse($student->payments as $payment)
                <div class="border-b border-gray-100 py-3 {{ $loop->last ? 'border-b-0' : '' }}">
                    <div class="flex justify-between items-center">
                        <span class="font-medium">{{ $payment->fee->fee_name }}</span>
                        <span class="text-green-600 font-medium">₱{{ number_format($payment->payment_amount, 2) }}</span>
                    </div>
                    <p class="text-sm text-gray-500">{{ $payment->payment_date->format('M d, Y') }}</p>
                </div>
            @empty
                <p class="text-gray-500">No payments yet</p>
            @endforelse
        </div>
    </div>

    <!-- Grades -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h4 class="text-lg font-semibold mb-4">Performance Records</h4>
        @forelse($student->grades as $grade)
            <div class="border border-gray-200 rounded-lg p-4 mb-4">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-lg font-medium">{{ $grade->academic_period }}</span>
                    <span class="text-sm text-gray-500">Teacher: {{ $grade->teacher->teacher_name }}</span>
                </div>
                <div class="grid grid-cols-5 gap-4 text-sm">
                    <div class="text-center">
                        <p class="text-gray-500">Cognitive</p>
                        <p class="font-medium capitalize">{{ str_replace('_', ' ', $grade->cognitive_skills) }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-500">Motor</p>
                        <p class="font-medium capitalize">{{ str_replace('_', ' ', $grade->motor_skills) }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-500">Social</p>
                        <p class="font-medium capitalize">{{ str_replace('_', ' ', $grade->social_skills) }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-500">Emotional</p>
                        <p class="font-medium capitalize">{{ str_replace('_', ' ', $grade->emotional_dev) }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-500">Behavior</p>
                        <p class="font-medium capitalize">{{ str_replace('_', ' ', $grade->behavior) }}</p>
                    </div>
                </div>
                @if($grade->teacher_remarks)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="text-sm text-gray-500">Teacher Remarks:</p>
                        <p class="text-sm">{{ $grade->teacher_remarks }}</p>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500">No performance records yet</p>
        @endforelse
    </div>
@endsection
