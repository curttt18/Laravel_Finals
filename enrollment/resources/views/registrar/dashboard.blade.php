@extends('layouts.registrar')

@section('page-title', 'Dashboard')

@section('content')
    @php
        $stats = [
            'total_students' => \App\Models\Student::count(),
            'total_teachers' => \App\Models\Teacher::count(),
            'pending_enrollments' => \App\Models\Enrollment::where('status', 'pending')->count(),
            'enrolled_students' => \App\Models\Enrollment::where('status', 'enrolled')->count(),
        ];
        $recentEnrollments = \App\Models\Enrollment::with('student')->orderBy('created_at', 'desc')->limit(5)->get();
    @endphp
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full"><svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Total Students</p><p class="text-2xl font-bold text-gray-800">{{ $stats['total_students'] }}</p></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full"><svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Enrolled</p><p class="text-2xl font-bold text-gray-800">{{ $stats['enrolled_students'] }}</p></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full"><svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Pending</p><p class="text-2xl font-bold text-gray-800">{{ $stats['pending_enrollments'] }}</p></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full"><svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Teachers</p><p class="text-2xl font-bold text-gray-800">{{ $stats['total_teachers'] }}</p></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200"><h3 class="text-lg font-semibold text-gray-800">Recent Enrollments (Pending Approval)</h3></div>
        <div class="p-6">
            @forelse($recentEnrollments->where('status', 'pending') as $enrollment)
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div><p class="font-medium text-gray-800">{{ $enrollment->student->student_name }}</p><p class="text-sm text-gray-500">{{ $enrollment->school_year }}</p></div>
                    <form action="{{ route('registrar.enrollments.approve', $enrollment) }}" method="POST">@csrf<button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">Approve</button></form>
                </div>
            @empty
                <p class="text-gray-500">No pending enrollments</p>
            @endforelse
        </div>
    </div>
@endsection
