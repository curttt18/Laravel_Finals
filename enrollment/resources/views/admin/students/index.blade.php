@php
    $prefix = request()->segment(1);
    $layout = match($prefix) {
        'registrar' => 'layouts.registrar',
        'cashier' => 'layouts.cashier',
        default => 'layouts.admin'
    };
    $roleLabel = ucfirst($prefix);
@endphp

@extends($layout)

@section('page-title', 'Students')
@section('breadcrumb', $roleLabel . ' / Students')

@section('page-actions')
    @if(Route::has($prefix . '.students.create'))
    <a href="{{ route($prefix . '.students.create') }}" class="btn btn-primary">
        <i class="ri-add-line"></i> Add Student
    </a>
    @endif
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Students</h3>
            <span style="color: #64748b; font-size: 0.85rem;">{{ $students->total() }} total</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th class="sortable" data-sort-type="number">ID</th>
                    <th class="sortable">Student</th>
                    <th class="sortable" data-sort-type="date">Date of Birth</th>
                    <th class="sortable">Gender</th>
                    <th class="sortable">Guardian</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td style="color: #64748b; font-weight: 600;">#{{ $student->student_id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; background: var(--c-teal); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9rem;">
                                    {{ substr($student->student_name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--c-dark);">{{ $student->student_name }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">{{ $student->contact_information }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $student->date_of_birth->format('M d, Y') }}</td>
                        <td>
                            @if($student->gender === 'male')
                                <span class="badge badge-info">
                                    <i class="ri-men-line"></i> Male
                                </span>
                            @else
                                <span class="badge" style="background: #fce7f3; color: #be185d;">
                                    <i class="ri-women-line"></i> Female
                                </span>
                            @endif
                        </td>
                        <td>{{ $student->guardian_name }}</td>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                @if(Route::has($prefix . '.students.show'))
                                <a href="{{ route($prefix . '.students.show', $student) }}" class="btn btn-sm btn-secondary" title="View">
                                    <i class="ri-eye-line"></i>
                                </a>
                                @endif
                                @if(Route::has($prefix . '.students.edit'))
                                <a href="{{ route($prefix . '.students.edit', $student) }}" class="btn btn-sm" style="background: var(--c-blue); color: white;" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                @endif
                                @if(Route::has($prefix . '.students.destroy'))
                                <form action="{{ route($prefix . '.students.destroy', $student) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <i class="ri-user-heart-line" style="font-size: 3rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                            No students found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $students->links() }}
        </div>
    @endif
@endsection
