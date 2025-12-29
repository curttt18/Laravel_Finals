@extends('layouts.admin')

@section('page-title', 'Users')
@section('breadcrumb', 'Admin / Users')

@section('page-actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="ri-add-line"></i> Add User
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Users</h3>
            <span style="color: #64748b; font-size: 0.85rem;">{{ $users->total() }} total</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td style="color: #64748b; font-weight: 600;">#{{ $user->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; background: {{ $user->role === 'admin' ? 'var(--c-coral)' : ($user->role === 'registrar' ? 'var(--c-blue)' : ($user->role === 'cashier' ? 'var(--success)' : 'var(--c-yellow)')) }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: {{ $user->role === 'student' ? 'var(--c-dark)' : 'white' }}; font-weight: 700; font-size: 0.9rem;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span style="font-weight: 600;">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td style="color: #64748b;">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge" style="background: #fae8ff; color: #86198f;">Admin</span>
                            @elseif($user->role === 'registrar')
                                <span class="badge badge-info">Registrar</span>
                            @elseif($user->role === 'cashier')
                                <span class="badge badge-success">Cashier</span>
                            @else
                                <span class="badge badge-warning">Student</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm" style="background: var(--c-blue); color: white;" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
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
                @endforeach
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $users->links() }}
        </div>
    @endif
@endsection
