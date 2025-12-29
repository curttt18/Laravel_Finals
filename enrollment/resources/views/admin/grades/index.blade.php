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

@section('page-title', 'Grades')
@section('breadcrumb', $roleLabel . ' / Grades')

@section('page-actions')
    <a href="{{ route($prefix . '.grades.create') }}" class="btn btn-primary">
        <i class="ri-add-line"></i> Add Grade
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Grade Records</h3>
            <span style="color: #64748b; font-size: 0.85rem;">{{ $grades->total() }} total</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th class="sortable" data-sort-type="number">ID</th>
                    <th class="sortable">Student</th>
                    <th class="sortable">Period</th>
                    <th class="sortable">Teacher</th>
                    <th>Performance</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grades as $grade)
                    <tr>
                        <td style="color: #64748b; font-weight: 600;">#{{ $grade->grade_id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; background: var(--c-teal); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem;">
                                    {{ substr($grade->student->student_name, 0, 1) }}
                                </div>
                                <span style="font-weight: 600;">{{ $grade->student->student_name }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge-info">{{ $grade->academic_period }}</span></td>
                        <td>{{ $grade->teacher->teacher_name }}</td>
                        <td>
                            <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                <span class="badge badge-{{ $grade->cognitive_skills === 'excellent' ? 'success' : ($grade->cognitive_skills === 'good' ? 'info' : 'warning') }}" style="font-size: 0.65rem;">Cog</span>
                                <span class="badge badge-{{ $grade->motor_skills === 'excellent' ? 'success' : ($grade->motor_skills === 'good' ? 'info' : 'warning') }}" style="font-size: 0.65rem;">Mot</span>
                                <span class="badge badge-{{ $grade->social_skills === 'excellent' ? 'success' : ($grade->social_skills === 'good' ? 'info' : 'warning') }}" style="font-size: 0.65rem;">Soc</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <a href="{{ route($prefix . '.grades.edit', $grade) }}" class="btn btn-sm" style="background: var(--c-blue); color: white;" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <form action="{{ route($prefix . '.grades.destroy', $grade) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <i class="ri-award-line" style="font-size: 3rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                            No grade records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($grades->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $grades->links() }}
        </div>
    @endif
@endsection
