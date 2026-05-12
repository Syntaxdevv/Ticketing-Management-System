@extends('layouts.master')

@section('title', 'Assigned Tickets')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">Assigned Tickets</h5>
        <p class="text-muted mb-0" style="font-size:12px;">Tickets assigned to you</p>
    </div>
    <span class="px-3 py-2 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);font-size:12px;color:#64748b;">
        <i class="ri-ticket-2-line me-1"></i> {{ $tickets->count() }} Tickets
    </span>
</div>

{{-- Table --}}
<div class="rounded-3 overflow-hidden" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#1a2235;font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.06em;">
                <tr>
                    <th class="px-4 py-3 border-0 fw-normal">#ID</th>
                    <th class="py-3 border-0 fw-normal">Title</th>
                    <th class="py-3 border-0 fw-normal">User</th>
                    <th class="py-3 border-0 fw-normal text-center">Priority</th>
                    <th class="py-3 border-0 fw-normal text-center">Status</th>
                    <th class="py-3 border-0 fw-normal text-center">Last Updated</th>
                    <th class="py-3 px-4 border-0 fw-normal text-center">Action</th>
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
                        <div class="fw-semibold" style="color:#e2e8f0;">{{ Str::limit($ticket->title, 35) }}</div>
                        <div style="font-size:11px;color:#475569;">{{ $ticket->category->name ?? 'Uncategorized' }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold flex-shrink-0"
                                 style="width:28px;height:28px;background:linear-gradient(135deg,#6366f1,#8b5cf6);font-size:11px;">
                                {{ strtoupper(substr($ticket->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span style="font-size:12px;color:#94a3b8;">{{ $ticket->user->name ?? 'Unknown' }}</span>
                        </div>
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
                    <td class="text-center" style="font-size:12px;color:#64748b;">
                        {{ $ticket->updated_at->diffForHumans() }}
                    </td>
                    <td class="text-center px-4">
                        <a href="{{ route('agent.tickets.show', $ticket->id) }}"
                           class="px-3 py-1 rounded-2 text-decoration-none"
                           style="background:rgba(99,102,241,0.15);color:#a5b4fc;font-size:12px;font-weight:500;">
                            <i class="ri-eye-line me-1"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#475569;font-size:13px;">
                        <i class="ri-inbox-archive-line d-block mb-2 fs-3"></i>
                       No tickets assigned.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection