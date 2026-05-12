@extends('layouts.master')

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">Ticket #{{ $ticket->id }}: {{ $ticket->title }}</h5>
        <p class="text-muted mb-0" style="font-size:12px;">Inireklamo ni: {{ $ticket->user->name }} · {{ $ticket->created_at->format('M d, Y h:i A') }}</p>
    </div>
    @php
        $sc = ['open'=>'rgba(14,165,233,0.15)','in-progress'=>'rgba(139,92,246,0.15)','resolved'=>'rgba(16,185,129,0.15)','closed'=>'rgba(239,68,68,0.15)'];
        $st = ['open'=>'#38bdf8','in-progress'=>'#a78bfa','resolved'=>'#34d399','closed'=>'#f87171'];
    @endphp
    <span class="px-3 py-1 rounded-pill fw-semibold" style="background:{{ $sc[$ticket->status] ?? 'rgba(255,255,255,0.05)' }};color:{{ $st[$ticket->status] ?? '#94a3b8' }};font-size:12px;">
        {{ ucfirst($ticket->status) }}
    </span>
</div>

<div class="row g-4">

    {{-- LEFT --}}
    <div class="col-lg-8">

        {{-- Ticket Info --}}
        <div class="rounded-3 p-4 mb-4" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:6px;">Description</div>
            <div style="font-size:13px;color:#94a3b8;line-height:1.7;">{{ $ticket->description }}</div>
        </div>

        {{-- Conversation --}}
        <div class="rounded-3 overflow-hidden" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="px-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <span class="text-white fw-semibold" style="font-size:13px;">
                    <i class="ri-chat-3-line me-2" style="color:#818cf8;"></i>Comments / Internal Notes
                </span>
            </div>

            <div class="p-4" style="max-height:380px;overflow-y:auto;">
                @forelse($ticket->comments as $comment)
                <div class="d-flex gap-3 mb-4 {{ $comment->user_id == auth()->id() ? 'flex-row-reverse' : '' }}">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
                         style="width:34px;height:34px;background:{{ $comment->user_id == auth()->id() ? 'linear-gradient(135deg,#6366f1,#8b5cf6)' : 'linear-gradient(135deg,#0ea5e9,#0284c7)' }};font-size:12px;flex-shrink:0;">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="mb-1 d-flex align-items-center gap-2 {{ $comment->user_id == auth()->id() ? 'flex-row-reverse' : '' }}">
                            <span class="fw-semibold" style="font-size:13px;color:{{ $comment->user_id == auth()->id() ? '#818cf8' : '#38bdf8' }};">
                                {{ $comment->user->name }}
                            </span>
                            <span style="font-size:11px;color:#475569;">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="rounded-3 px-3 py-2" style="background:#1a2235;color:#cbd5e1;font-size:13px;line-height:1.6;border-left:{{ $comment->user_id == auth()->id() ? 'none;border-right' : '' }}:2px solid {{ $comment->user_id == auth()->id() ? '#6366f1' : '#0ea5e9' }};">
                            {{ $comment->message }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4" style="color:#475569;font-size:13px;">
                    <i class="ri-chat-3-line d-block mb-2 fs-3"></i>
                    There are no discussions here yet. Start a conversation below.
                </div>
                @endforelse
            </div>

            {{-- Reply Form --}}
            <div class="px-4 pb-4" style="border-top:1px solid rgba(255,255,255,0.06);padding-top:16px;">
                <form action="{{ route('comments.store', $ticket->id) }}" method="POST">
                    @csrf
                    <textarea name="message" rows="3" class="form-control mb-3"
                        placeholder="Mag-reply dito..."
                        style="background:#1a2235;border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;border-radius:10px;resize:none;font-size:13px;"
                        required></textarea>
                    <button type="submit" class="btn fw-semibold px-4"
                        style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;border:none;">
                        <i class="ri-send-plane-line me-1"></i> Send Reply
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- RIGHT --}}
    <div class="col-lg-4">

        {{-- Update Status --}}
        <div class="rounded-3 p-4 mb-4" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="mb-3 pb-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <span class="text-white fw-semibold" style="font-size:13px;">Update Status</span>
            </div>
            <form action="{{ route('agent.tickets.updateStatus', $ticket->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label class="mb-2" style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;">Status</label>
                    <select name="status" class="form-select"
                        style="background:#1a2235;border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;border-radius:8px;font-size:13px;">
                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in-progress" {{ $ticket->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
                <button type="submit" class="btn w-100 fw-semibold"
                    style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;border:none;">
                    <i class="ri-refresh-line me-1"></i> Save Changes
                </button>
            </form>
        </div>

        {{-- Ticket Details --}}
        <div class="rounded-3 p-4" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="mb-3 pb-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <span class="text-white fw-semibold" style="font-size:13px;">Ticket Info</span>
            </div>
            <div class="mb-3">
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">Reported By</div>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
                         style="width:28px;height:28px;background:linear-gradient(135deg,#6366f1,#8b5cf6);font-size:11px;">
                        {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                    </div>
                    <span style="font-size:13px;color:#e2e8f0;">{{ $ticket->user->name }}</span>
                </div>
            </div>
            <div class="mb-3">
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">Category</div>
                <div style="font-size:13px;color:#e2e8f0;">{{ $ticket->category->name ?? 'N/A' }}</div>
            </div>
            <div class="mb-3">
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">Priority</div>
                @php
                    $pc = ['high'=>'rgba(239,68,68,0.15)','medium'=>'rgba(245,158,11,0.15)','low'=>'rgba(16,185,129,0.15)'];
                    $pt = ['high'=>'#f87171','medium'=>'#fbbf24','low'=>'#34d399'];
                @endphp
                <span class="px-3 py-1 rounded-pill" style="background:{{ $pc[$ticket->priority] ?? 'rgba(255,255,255,0.05)' }};color:{{ $pt[$ticket->priority] ?? '#94a3b8' }};font-size:12px;font-weight:500;">
                    {{ ucfirst($ticket->priority) }}
                </span>
            </div>
            <div>
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">Created</div>
                <div style="font-size:13px;color:#e2e8f0;">{{ $ticket->created_at->format('M d, Y h:i A') }}</div>
            </div>
        </div>

    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        background:#1a2235 !important;
        border-color:#6366f1 !important;
        color:#e2e8f0 !important;
        box-shadow:none !important;
    }
    .form-select option { background:#1a2235; color:#e2e8f0; }
    .form-control::placeholder { color:#475569 !important; }
</style>

@endsection