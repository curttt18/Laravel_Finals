@extends('layouts.admin')

@section('page-title', 'Edit Fee')
@section('breadcrumb', 'Admin / Fees / Edit')

@section('page-actions')
    <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-edit-line" style="margin-right: 8px; color: var(--c-blue);"></i>Edit Fee</h3>
        </div>
        
        <form action="{{ route('admin.fees.update', $fee) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="fee_name" class="form-label">Fee Name</label>
                <input type="text" name="fee_name" id="fee_name" value="{{ old('fee_name', $fee->fee_name) }}" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="amount" class="form-label">Amount (₱)</label>
                <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $fee->amount) }}" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="2" class="form-control" placeholder="Optional description...">{{ old('description', $fee->description) }}</textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Update Fee
                </button>
            </div>
        </form>
    </div>
@endsection
