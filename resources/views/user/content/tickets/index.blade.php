@extends('layouts.master')

@section('title', 'My Tickets')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">My Tickets</h5>
        <p class="text-muted mb-0" style="font-size:12px;">Manage and track your support requests</p>
    </div>
    <a href="{{ route('tickets.create') }}" class="btn px-4 fw-semibold"
       style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;border:none;">
        <i class="ri-add-line me-1"></i> New Ticket
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(99,102,241,0.15);color:#818cf8;font-size:18px;">
                <i class="ri-ticket-2-line"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">{{ $tickets->total() }}</div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">Total Tickets</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(14,165,233,0.15);color:#38bdf8;font-size:18px;">
                <i class="ri-broadcast-line"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">{{ $tickets->getCollection()->where('status','open')->count() }}</div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">Open</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(16,185,129,0.15);color:#34d399;font-size:18px;">
                <i class="ri-shield-check-line"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">{{ $tickets->getCollection()->where('status','resolved')->count() }}</div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">Resolved</div>
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
                    <th class="px-4 py-3 border-0 fw-normal">#ID</th>
                    <th class="py-3 border-0 fw-normal">Title</th>
                    <th class="py-3 border-0 fw-normal">Category</th>
                    <th class="py-3 border-0 fw-normal text-center">Priority</th>
                    <th class="py-3 border-0 fw-normal text-center">Status</th>
                    <th class="py-3 border-0 fw-normal text-center">Rating</th>
                    <th class="py-3 border-0 fw-normal">Last Updated</th>
                    <th class="px-4 py-3 border-0 fw-normal text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                @php
                    $pc = ['high'=>'rgba(239,68,68,0.15)','medium'=>'rgba(245,158,11,0.15)','low'=>'rgba(16,185,129,0.15)'];
                    $pt = ['high'=>'#f87171','medium'=>'#fbbf24','low'=>'#34d399'];
                    $sc = ['open'=>'rgba(14,165,233,0.15)','in-progress'=>'rgba(139,92,246,0.15)','resolved'=>'rgba(16,185,129,0.15)','closed'=>'rgba(239,68,68,0.15)'];
                    $st = ['open'=>'#38bdf8','in-progress'=>'#a78bfa','resolved'=>'#34d399','closed'=>'#f87171'];
                @endphp
                <tr style="border-bottom:1px solid rgba(255,255,255,0.04);font-size:13px;">
                    <td class="px-4" style="color:#64748b;">#{{ $ticket->id }}</td>
                    <td>
                        <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none fw-semibold" style="color:#818cf8;">
                            {{ Str::limit($ticket->title, 35) }}
                        </a>
                    </td>
                    <td>
                        <span class="px-3 py-1 rounded-pill" style="background:rgba(255,255,255,0.05);color:#64748b;font-size:11px;border:1px solid rgba(255,255,255,0.07);">
                            {{ $ticket->category->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="px-3 py-1 rounded-pill" style="background:{{ $pc[$ticket->priority] ?? 'rgba(255,255,255,0.05)' }};color:{{ $pt[$ticket->priority] ?? '#94a3b8' }};font-size:11px;font-weight:500;">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="px-3 py-1 rounded-pill" style="background:{{ $sc[$ticket->status] ?? 'rgba(255,255,255,0.05)' }};color:{{ $st[$ticket->status] ?? '#94a3b8' }};font-size:11px;font-weight:500;">
                            {{ ucfirst(str_replace('-', ' ', $ticket->status)) }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($ticket->rating)
                            <span class="px-3 py-1 rounded-pill" style="background:rgba(245,158,11,0.15);color:#fbbf24;font-size:11px;font-weight:500;">
                                {{ ucfirst($ticket->rating) }}
                            </span>
                        @else
                            <span style="color:#475569;">—</span>
                        @endif
                    </td>
                    <td style="color:#64748b;font-size:12px;">{{ $ticket->updated_at->diffForHumans() }}</td>
                    <td class="px-4 text-end">
                        <div class="d-inline-flex gap-2">
                            <a href="{{ route('tickets.show', $ticket) }}"
                               class="d-flex align-items-center justify-content-center rounded-2 text-decoration-none gap-1 px-3"
                               style="height:30px;background:rgba(99,102,241,0.15);color:#a5b4fc;font-size:12px;font-weight:500;">
                                <i class="ri-eye-line"></i> View
                            </a>
                            @if($ticket->status == 'open')
                                <button type="button"
                                        class="d-flex align-items-center justify-content-center rounded-2 border-0"
                                        style="width:30px;height:30px;background:rgba(239,68,68,0.15);color:#f87171;font-size:14px;cursor:pointer;"
                                        data-bs-toggle="modal" data-bs-target="#confirmModal"
                                        data-form-action="{{ route('tickets.destroy', $ticket) }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5" style="color:#475569;">
                        <i class="ri-inbox-archive-line d-block mb-3" style="font-size:40px;"></i>
                        <div class="text-white fw-semibold mb-1">No tickets yet</div>
                        <div style="font-size:13px;margin-bottom:16px;">Create your first support ticket to get started.</div>
                        <a href="{{ route('tickets.create') }}" class="btn px-4 fw-semibold"
                           style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;border:none;">
                            Create Ticket
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
    <div class="px-4 py-3" style="border-top:1px solid rgba(255,255,255,0.05);">
        {{ $tickets->links() }}
    </div>
    @endif
</div>

@endsection
{{-- Isama mo itong Modal na ito sa dulo ng file --}}
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0" style="background: #1a2235; border-radius: 16px;">
            <div class="modal-body text-center p-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" 
                     style="width: 70px; height: 70px; background: rgba(239, 68, 68, 0.1); color: #f87171;">
                    <i class="ri-error-warning-line" style="font-size: 35px;"></i>
                </div>
                <h5 class="text-white fw-bold mb-2">Delete Ticket?</h5>
                <p class="text-muted mb-4" style="font-size: 14px;">Sigurado ka bang gusto mong burahin ang ticket na ito? Hindi na ito mababalik.</p>
                
                <div class="d-flex gap-2">
                    <button type="button" class="btn w-100 fw-semibold" data-bs-dismiss="modal" 
                            style="background: rgba(255,255,255,0.05); color: #94a3b8; border: none; border-radius: 10px; padding: 12px;">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="w-100">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 fw-semibold" 
                                style="border-radius: 10px; padding: 12px; background: #ef4444; border: none;">
                            Delete Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var confirmModal = document.getElementById('confirmModal');
        confirmModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var actionUrl = button.getAttribute('data-form-action');
            var form = document.getElementById('deleteForm');
            form.setAttribute('action', actionUrl);
        });
    });
</script>