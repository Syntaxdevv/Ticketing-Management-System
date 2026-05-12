@extends('layouts.master')

@section('title', 'Manage Categories')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">Ticket Categories</h5>
        <p class="text-muted mb-0" style="font-size:12px;">Manage all support ticket categories</p>
    </div>
    <button type="button" class="btn px-4 fw-semibold"
            style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;border:none;"
            data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="ri-add-line me-1"></i> Add New Category
    </button>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(99,102,241,0.15);color:#818cf8;font-size:18px;">
                <i class="ri-list-check-2"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">{{ $categories->count() }}</div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">Total Categories</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(14,165,233,0.15);color:#38bdf8;font-size:18px;">
                <i class="ri-ticket-2-line"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">{{ $categories->sum('tickets_count') }}</div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">Total Tickets</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(16,185,129,0.15);color:#34d399;font-size:18px;">
                <i class="ri-bar-chart-line"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">
                    {{ $categories->count() > 0 ? round($categories->sum('tickets_count') / $categories->count(), 1) : 0 }}
                </div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">Avg Tickets/Category</div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="rounded-3 overflow-hidden" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#1a2235;font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.06em;">
                <tr>
                    <th class="px-4 py-3 border-0 fw-normal">Category Name</th>
                    <th class="py-3 border-0 fw-normal text-center">Total Tickets</th>
                    <th class="py-3 border-0 fw-normal text-center">Created At</th>
                    <th class="py-3 px-4 border-0 fw-normal text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr style="border-bottom:1px solid rgba(255,255,255,0.04);font-size:13px;">
                    <td class="px-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                                 style="width:34px;height:34px;background:rgba(99,102,241,0.12);color:#818cf8;font-size:15px;">
                                <i class="ri-folder-line"></i>
                            </div>
                            <span class="fw-semibold" style="color:#e2e8f0;">{{ $category->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <span class="px-3 py-1 rounded-pill" style="background:{{ $category->tickets_count > 0 ? 'rgba(14,165,233,0.15)' : 'rgba(255,255,255,0.05)' }};color:{{ $category->tickets_count > 0 ? '#38bdf8' : '#475569' }};font-size:12px;font-weight:500;">
                            {{ $category->tickets_count }} {{ Str::plural('ticket', $category->tickets_count) }}
                        </span>
                    </td>
                    <td class="py-3 text-center" style="color:#64748b;font-size:12px;">
                        {{ $category->created_at->format('M d, Y') }}
                    </td>
                   <td class="py-3 px-4 text-end">

    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" 
          onsubmit="return confirm('Are you sure you want to delete this category?')">
        @csrf
        @method('DELETE')
        
        <button type="submit" class="d-inline-flex align-items-center justify-content-center rounded-2 border-0"
                style="width:30px;height:30px;background:rgba(239,68,68,0.15);color:#f87171;font-size:14px;cursor:pointer;"
                title="Delete Category">
            <i class="ri-delete-bin-line"></i>
        </button>
    </form>
</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5" style="color:#475569;font-size:13px;">
                        <i class="ri-list-check-2 d-block mb-2 fs-3"></i>
                        No categories found. Create your first one!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Category Modal --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);border-radius:12px;">
            <div class="modal-header" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <h6 class="modal-title text-white fw-semibold">Create New Category</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <label class="mb-2" style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;">Category Name</label>
                    <input type="text" name="name" class="form-control"
                           style="background:#1a2235;border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;border-radius:8px;font-size:13px;"
                           placeholder="e.g. Technical Issue" required>
                </div>
                <div class="modal-footer" style="border-top:1px solid rgba(255,255,255,0.06);">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-size:13px;">Cancel</button>
                    <button type="submit" class="btn fw-semibold px-4"
                            style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;border:none;">
                        <i class="ri-add-line me-1"></i> Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background:#1a2235 !important;
        border-color:#6366f1 !important;
        color:#e2e8f0 !important;
        box-shadow:none !important;
    }
</style>

@endsection