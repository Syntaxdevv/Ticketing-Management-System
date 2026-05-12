@extends('layouts.master')

@section('title', 'Ticket #' . $ticket->id)

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">Ticket #{{ $ticket->id }}: {{ $ticket->title }}</h5>
        <p class="text-muted mb-0" style="font-size:12px;">Created {{ $ticket->created_at->format('d M Y, H:i') }}</p>
    </div>
    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary px-4">
        <i class="ri-arrow-left-line me-1"></i> Back
    </a>
</div>

<div class="row g-4">

    {{-- LEFT: Ticket Info & Images --}}
    <div class="col-lg-3">
        <div class="rounded-3 p-4 mb-4" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

            <div class="mb-4">
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:6px;">Category</div>
                <div class="text-white fw-semibold" style="font-size:14px;">{{ $ticket->category->name ?? 'N/A' }}</div>
            </div>

            <div class="mb-4">
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:6px;">Priority</div>
                @php
                    $pc = ['high'=>'rgba(239,68,68,0.2)','medium'=>'rgba(245,158,11,0.2)','low'=>'rgba(250,204,21,0.2)'];
                    $pt = ['high'=>'#f87171','medium'=>'#fbbf24','low'=>'#fde047'];
                @endphp
                <span class="px-3 py-1 rounded-pill" style="background:{{ $pc[$ticket->priority] ?? 'rgba(255,255,255,0.05)' }};color:{{ $pt[$ticket->priority] ?? '#94a3b8' }};font-size:12px;font-weight:500;">
                    {{ ucfirst($ticket->priority) }}
                </span>
            </div>

            <div class="mb-4">
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:6px;">Status</div>
                <span class="px-3 py-1 rounded-pill" style="background:rgba(99,102,241,0.2);color:#a5b4fc;font-size:12px;font-weight:500;">
                    {{ ucfirst($ticket->status) }}
                </span>
            </div>

            @if($ticket->description)
            <div class="mb-4">
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:6px;">Description</div>
                <div style="font-size:13px;color:#94a3b8;line-height:1.6;">{{ $ticket->description }}</div>
            </div>
            @endif

            {{-- ATTACHED IMAGES SECTION --}}
            @if($ticket->images && count($ticket->images) > 0)
            <div class="mt-4 border-top pt-4" style="border-color: rgba(255,255,255,0.05) !important;">
                <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:12px;">Attachments</div>
                <div class="row g-2">
                    @foreach($ticket->images as $image)
                    <div class="col-6">
                        <a href="{{ asset('storage/' . $image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $image) }}" 
                                 class="img-fluid rounded-2 border border-secondary" 
                                 style="height: 80px; width: 100%; object-fit: cover; border-color: rgba(255,255,255,0.1) !important;"
                                 alt="Attachment">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- RIGHT: Conversation --}}
    <div class="col-lg-9">
        <div class="rounded-3 overflow-hidden" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

            <div class="px-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                <span class="text-white fw-semibold" style="font-size:13px;">Conversation</span>
            </div>

            <div class="p-4" style="min-height:200px;">
                @forelse($ticket->comments as $comment)
                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
                         style="width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#8b5cf6);font-size:13px;">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="mb-1">
                            <span class="text-white fw-semibold" style="font-size:13px;">{{ $comment->user->name }}</span>
                            <span class="ms-2" style="font-size:11px;color:#64748b;">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="rounded-3 px-3 py-2" style="background:#1a2235;color:#cbd5e1;font-size:13px;line-height:1.6;">
                            {{ $comment->message }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4" style="color:#64748b;font-size:13px;">
                    <i class="ri-chat-3-line d-block mb-2 fs-3"></i>
                    No messages yet. Start the conversation!
                </div>
                @endforelse
            </div>

            <div class="px-4 pb-4">
                <form action="{{ route('comments.store', $ticket->id) }}" method="POST">
                    @csrf
                    <textarea name="message" rows="3" class="form-control mb-3"
                        placeholder="Write your reply..."
                        style="background:#1a2235;border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;border-radius:10px;resize:none;font-size:13px;"
                        required></textarea>
                    <button type="submit" class="btn px-4 fw-semibold"
                        style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;">
                        <i class="ri-send-plane-line me-1"></i> Send Reply
                    </button>
                </form>
            </div>
        </div>

        {{-- Feedback & Reopen --}}
        @if(in_array($ticket->status, ['resolved', 'closed']))
        <div class="mt-4 p-4 rounded-3 text-center" style="background:#252d3d;border:1px solid rgba(250,204,21,0.2);">
            @if(!$ticket->rating)
                <h6 class="text-white mb-3">Is your issue resolved? Please give feedback:</h6>
                <form action="{{ route('tickets.feedback', $ticket->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button name="rating" value="excellent" class="btn me-2 px-4 fw-semibold" style="background:rgba(16,185,129,0.2);color:#34d399;border:1px solid rgba(16,185,129,0.3);">Excellent</button>
                    <button name="rating" value="good" class="btn px-4 fw-semibold" style="background:rgba(99,102,241,0.2);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);">Good</button>
                </form>
            @else
                <div class="text-success">Feedback submitted: <strong>{{ ucfirst($ticket->rating) }}</strong></div>
            @endif
            <form action="{{ route('tickets.reopen', $ticket->id) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn px-4 fw-semibold" style="background:rgba(250,204,21,0.1);color:#fde047;border:1px solid rgba(250,204,21,0.2);">
                    <i class="ri-refresh-line me-1"></i> Not Satisfied? Reopen Ticket
                </button>
            </form>
        </div>
        @endif
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