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

@section('page-title', 'Teachers')
@section('breadcrumb', $roleLabel . ' / Teachers')

@section('page-actions')
    <a href="{{ route($prefix . '.teachers.create') }}" class="btn btn-primary">
        <i class="ri-add-line"></i> Add Teacher
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Teachers</h3>
            <span style="color: #64748b; font-size: 0.85rem;">{{ $teachers->total() }} total</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Teacher</th>
                    <th>Contact</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td style="color: #64748b; font-weight: 600;">#{{ $teacher->teacher_id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; background: var(--c-blue); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9rem;">
                                    {{ substr($teacher->teacher_name, 0, 1) }}
                                </div>
                                <div style="font-weight: 600; color: var(--c-dark);">{{ $teacher->teacher_name }}</div>
                            </div>
                        </td>
                        <td>{{ $teacher->contact_information }}</td>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <a href="{{ route($prefix . '.teachers.edit', $teacher) }}" class="btn btn-sm" style="background: var(--c-blue); color: white;" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <form action="{{ route($prefix . '.teachers.destroy', $teacher) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this teacher?')">
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
                        <td colspan="4" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <i class="ri-user-star-line" style="font-size: 3rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                            No teachers found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($teachers->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $teachers->links() }}
        </div>
    @endif
@endsection
