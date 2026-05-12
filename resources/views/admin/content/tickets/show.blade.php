@extends('layouts.master')

@section('title', 'Ticket #' . $ticket->id . ' - Admin View')

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">Ticket Details: #{{ $ticket->id }}</h5>
        <p class="text-muted mb-0" style="font-size:12px;">Created {{ $ticket->created_at->format('M d, Y h:i A') }}</p>
    </div>
    <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary px-4">
        <i class="ri-arrow-left-line me-1"></i> Back to List
    </a>
</div>

<div class="row g-4">

    <div class="col-lg-8">

        <div class="rounded-3 p-4 mb-4" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <h5 class="fw-semibold mb-0" style="color:#818cf8;">{{ $ticket->title }}</h5>
                @php
                    $pc = ['high'=>'rgba(239,68,68,0.2)','medium'=>'rgba(245,158,11,0.2)','low'=>'rgba(16,185,129,0.2)'];
                    $pt = ['high'=>'#f87171','medium'=>'#fbbf24','low'=>'#34d399'];
                @endphp
                <span class="px-3 py-1 rounded-pill fw-semibold" style="background:{{ $pc[$ticket->priority] ?? 'rgba(255,255,255,0.05)' }};color:{{ $pt[$ticket->priority] ?? '#94a3b8' }};font-size:11px;">
                    {{ strtoupper($ticket->priority) }} PRIORITY
                </span>
            </div>
            <div class="row mb-3" style="font-size:12px;color:#64748b;">
                <div class="col-md-4">
                    <span style="text-transform:uppercase;letter-spacing:.06em;font-size:10px;">User</span>
                    <div class="text-white mt-1">{{ $ticket->user->name }}</div>
                </div>
                <div class="col-md-4">
                    <span style="text-transform:uppercase;letter-spacing:.06em;font-size:10px;">Category</span>
                    <div class="text-white mt-1">{{ $ticket->category->name }}</div>
                </div>
                <div class="col-md-4">
                    <span style="text-transform:uppercase;letter-spacing:.06em;font-size:10px;">Status</span>
                    @php
                        $sc = ['open'=>'rgba(14,165,233,0.15)','in-progress'=>'rgba(139,92,246,0.15)','resolved'=>'rgba(16,185,129,0.15)','closed'=>'rgba(239,68,68,0.15)'];
                        $st = ['open'=>'#38bdf8','in-progress'=>'#a78bfa','resolved'=>'#34d399','closed'=>'#f87171'];
                    @endphp
                    <div class="mt-1">
                        <span class="px-2 py-1 rounded-pill" style="background:{{ $sc[$ticket->status] ?? 'rgba(255,255,255,0.05)' }};color:{{ $st[$ticket->status] ?? '#94a3b8' }};font-size:11px;font-weight:500;">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </div>
                </div>
            </div>
            <div style="border-top:1px solid rgba(255,255,255,0.06);padding-top:14px;font-size:13px;color:#94a3b8;line-height:1.7;">
                {!! nl2br(e($ticket->description)) !!}
            </div>
        </div>

        <div class="rounded-3 overflow-hidden mb-4" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="px-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <span class="text-white fw-semibold" style="font-size:13px;"><i class="ri-chat-3-line me-2"></i>Conversation</span>
            </div>
            <div class="p-4" style="min-height:150px;">
                @forelse($ticket->comments as $comment)
                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
                         style="width:36px;height:36px;background:{{ in_array($comment->user->role, ['admin','agent']) ? 'linear-gradient(135deg,#10b981,#059669)' : 'linear-gradient(135deg,#6366f1,#8b5cf6)' }};font-size:13px;">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="mb-1 d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="font-size:13px;color:{{ in_array($comment->user->role, ['admin','agent']) ? '#34d399' : '#818cf8' }};">
                                {{ $comment->user->name }}
                            </span>
                            @if(in_array($comment->user->role, ['admin','agent']))
                                <span class="px-2 py-0 rounded-pill" style="background:rgba(16,185,129,0.15);color:#34d399;font-size:10px;font-weight:500;">STAFF</span>
                            @endif
                            <span style="font-size:11px;color:#475569;">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="rounded-3 px-3 py-2" style="background:#1a2235;color:#cbd5e1;font-size:13px;line-height:1.6;border-left:2px solid {{ in_array($comment->user->role, ['admin','agent']) ? '#10b981' : '#6366f1' }};">
                            {{ $comment->message }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4" style="color:#475569;font-size:13px;">
                    <i class="ri-chat-3-line d-block mb-2 fs-3"></i>
                    No conversation yet.
                </div>
                @endforelse
            </div>

            <div class="px-4 pb-4" style="border-top:1px solid rgba(255,255,255,0.06);padding-top:16px;">
                <div class="mb-2" style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;">Reply as Support Team</div>
                <form action="{{ route('comments.store', $ticket) }}" method="POST">
                    @csrf
                    <textarea name="message" rows="3" class="form-control mb-3"
                        placeholder="Write your response here..."
                        style="background:#1a2235;border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;border-radius:10px;resize:none;font-size:13px;"
                        required></textarea>
                    <button type="submit" class="btn fw-semibold px-4"
                        style="background:#10b981;color:#fff;border-radius:8px;font-size:13px;border:none;">
                        <i class="ri-send-plane-line me-1"></i> Send Reply
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- RIGHT: Actions --}}
    <div class="col-lg-4">

        {{-- Update Status --}}
        <div class="rounded-3 p-4 mb-4" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="mb-3 pb-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <span class="text-white fw-semibold" style="font-size:13px;">Update Status</span>
            </div>
            <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label class="mb-2" style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;">Status</label>
                    <select name="status" class="form-select" style="background:#1a2235;border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;border-radius:8px;font-size:13px;">
                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in-progress" {{ $ticket->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-2" style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;">Priority</label>
                    <select name="priority" class="form-select" style="background:#1a2235;border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;border-radius:8px;font-size:13px;">
                        <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
                <button type="submit" class="btn w-100 fw-semibold"
                    style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;border:none;">
                    <i class="ri-refresh-line me-1"></i> Update Ticket
                </button>
            </form>
        </div>

        {{-- Assign Agent --}}
        <div class="rounded-3 p-4" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="mb-3 pb-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <span class="text-white fw-semibold" style="font-size:13px;">Assign Agent</span>
            </div>
            <form action="{{ route('admin.tickets.assign', $ticket) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="mb-2" style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;">Agent</label>
                    <select name="assigned_to" class="form-select" style="background:#1a2235;border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;border-radius:8px;font-size:13px;">
                        <option value="">Unassigned</option>
                        @foreach(\App\Models\User::whereIn('role', ['agent', 'admin'])->get() as $agent)
                            <option value="{{ $agent->id }}" {{ $ticket->assigned_to == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }} ({{ ucfirst($agent->role) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn w-100 fw-semibold"
                    style="background:#1a2235;color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);border-radius:8px;font-size:13px;">
                    <i class="ri-user-follow-line me-1"></i> Update Assignment
                </button>
            </form>
        </div>

    </div>
</div>

<style>
    .form-select:focus, .form-control:focus {
        background:#1a2235 !important;
        border-color:#6366f1 !important;
        color:#e2e8f0 !important;
        box-shadow:none !important;
    }
    .form-select option { background:#1a2235; color:#e2e8f0; }
</style>

@endsection