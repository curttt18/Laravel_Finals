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

@section('page-title', 'Enrollments')
@section('breadcrumb', $roleLabel . ' / Enrollments')

@section('page-actions')
    <a href="{{ route($prefix . '.enrollments.create') }}" class="btn btn-primary">
        <i class="ri-add-line"></i> Add Enrollment
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Enrollments</h3>
            <span style="color: #64748b; font-size: 0.85rem;">{{ $enrollments->total() }} total</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th class="sortable" data-sort-type="number">ID</th>
                    <th class="sortable">Student</th>
                    <th class="sortable">School Year</th>
                    <th class="sortable" data-sort-type="date">Date</th>
                    <th class="sortable">Status</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td style="color: #64748b; font-weight: 600;">#{{ $enrollment->enrollment_id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 36px; height: 36px; background: var(--c-teal); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.8rem;">
                                    {{ substr($enrollment->student->student_name, 0, 1) }}
                                </div>
                                <span style="font-weight: 600;">{{ $enrollment->student->student_name }}</span>
                            </div>
                        </td>
                        <td>{{ $enrollment->school_year }}</td>
                        <td>{{ $enrollment->enrollment_date->format('M d, Y') }}</td>
                        <td>
                            @if($enrollment->status === 'enrolled')
                                <span class="badge badge-success">Enrolled</span>
                            @elseif($enrollment->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">{{ ucfirst($enrollment->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                @if($enrollment->status === 'pending')
                                    <form action="{{ route($prefix . '.enrollments.approve', $enrollment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                            <i class="ri-check-line"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route($prefix . '.enrollments.edit', $enrollment) }}" class="btn btn-sm" style="background: var(--c-blue); color: white;" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <form action="{{ route($prefix . '.enrollments.destroy', $enrollment) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
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
                            <i class="ri-file-list-3-line" style="font-size: 3rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                            No enrollments found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($enrollments->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $enrollments->links() }}
        </div>
    @endif
@endsection
