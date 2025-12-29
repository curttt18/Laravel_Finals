@extends('layouts.admin')

@section('page-title', 'Add Fee')
@section('breadcrumb', 'Admin / Fees / Create')

@section('page-actions')
    <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-price-tag-3-line" style="margin-right: 8px; color: var(--c-coral);"></i>Add New Fee</h3>
        </div>
        
        <form action="{{ route('admin.fees.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="fee_name" class="form-label">Fee Name</label>
                <input type="text" name="fee_name" id="fee_name" value="{{ old('fee_name') }}" class="form-control" placeholder="e.g., Tuition Fee, Materials Fee" required>
            </div>
            
            <div class="form-group">
                <label for="amount" class="form-label">Amount (₱)</label>
                <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" class="form-control" placeholder="0.00" required>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">Description <span style="color: #94a3b8; font-weight: 400;">(optional)</span></label>
                <textarea name="description" id="description" rows="2" class="form-control" placeholder="Brief description of this fee...">{{ old('description') }}</textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-add-line"></i> Create Fee
                </button>
            </div>
        </form>
    </div>
@endsection
