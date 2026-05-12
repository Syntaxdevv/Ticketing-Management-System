@extends('layouts.master')

@section('title', 'Manage All Tickets')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">
            Manage All Tickets
        </h5>

        <p class="text-muted mb-0" style="font-size:12px;">
            Overview of all support tickets
        </p>
    </div>
</div>

@php
    $total         = $tickets->total();
    $openCount     = $tickets->getCollection()->where('status', 'open')->count();
    $resolvedCount = $tickets->getCollection()->where('status', 'resolved')->count();
    $closedCount   = $tickets->getCollection()->where('status', 'closed')->count();
@endphp

{{-- Stats Cards --}}
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3"
             style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(99,102,241,0.15);color:#818cf8;font-size:18px;">
                <i class="ri-ticket-2-line"></i>
            </div>

            <div>
                <div class="fw-semibold text-white"
                     style="font-size:20px;line-height:1;">
                    {{ \App\Models\Ticket::count() }}
                </div>

                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">
                    Total
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-3">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3"
             style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(14,165,233,0.15);color:#38bdf8;font-size:18px;">
                <i class="ri-broadcast-line"></i>
            </div>

            <div>
                <div class="fw-semibold text-white"
                     style="font-size:20px;line-height:1;">
                    {{ \App\Models\Ticket::where('status','open')->count() }}
                </div>

                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">
                    Open
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-3">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3"
             style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(16,185,129,0.15);color:#34d399;font-size:18px;">
                <i class="ri-shield-check-line"></i>
            </div>

            <div>
                <div class="fw-semibold text-white"
                     style="font-size:20px;line-height:1;">
                    {{ \App\Models\Ticket::where('status','resolved')->count() }}
                </div>

                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">
                    Resolved
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-3">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3"
             style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(239,68,68,0.15);color:#f87171;font-size:18px;">
                <i class="ri-lock-line"></i>
            </div>

            <div>
                <div class="fw-semibold text-white"
                     style="font-size:20px;line-height:1;">
                    {{ \App\Models\Ticket::where('status','closed')->count() }}
                </div>

                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">
                    Closed
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.tickets.index') }}" class="mb-3">
    <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
         style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

        <i class="ri-search-line" style="color:#475569;"></i>

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search tickets by title, user, or category..."
               class="border-0 bg-transparent text-white w-100"
               style="outline:none;font-size:13px;">
    </div>
</form>

{{-- Table --}}
<div class="rounded-3 overflow-hidden"
     style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

    <div class="table-responsive">
        <table class="table mb-0 align-middle">

            <thead style="background:#1a2235;font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.06em;">
                <tr>
                    <th class="px-4 py-3 border-0 fw-normal">#ID</th>
                    <th class="py-3 border-0 fw-normal">Title</th>
                    <th class="py-3 border-0 fw-normal">User</th>
                    <th class="py-3 border-0 fw-normal">Category</th>
                    <th class="py-3 border-0 fw-normal text-center">Status</th>
                    <th class="py-3 border-0 fw-normal text-center">Priority</th>
                    <th class="py-3 px-4 border-0 fw-normal text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($tickets as $ticket)

                @php
                    $sc = [
                        'open'        => 'rgba(14,165,233,0.15)',
                        'in-progress' => 'rgba(139,92,246,0.15)',
                        'resolved'    => 'rgba(16,185,129,0.15)',
                        'closed'      => 'rgba(239,68,68,0.15)'
                    ];

                    $st = [
                        'open'        => '#38bdf8',
                        'in-progress' => '#a78bfa',
                        'resolved'    => '#34d399',
                        'closed'      => '#f87171'
                    ];

                    $pc = [
                        'high'   => 'rgba(239,68,68,0.15)',
                        'medium' => 'rgba(245,158,11,0.15)',
                        'low'    => 'rgba(16,185,129,0.15)'
                    ];

                    $pt = [
                        'high'   => '#f87171',
                        'medium' => '#fbbf24',
                        'low'    => '#34d399'
                    ];
                @endphp

                <tr style="border-bottom:1px solid rgba(255,255,255,0.04);font-size:13px;">
                    <td class="px-4" style="color:#64748b;">#{{ $ticket->id }}</td>

                    <td>
                        <span class="fw-semibold" style="color:#e2e8f0;">
                            {{ Str::limit($ticket->title, 30) }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex align-items-center gap-2">

                            <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold flex-shrink-0"
                                 style="width:28px;height:28px;background:linear-gradient(135deg,#6366f1,#8b5cf6);font-size:11px;">
                                {{ strtoupper(substr($ticket->user->name ?? 'U', 0, 1)) }}
                            </div>

                            <span style="color:#94a3b8;font-size:12px;">
                                {{ $ticket->user->name ?? 'Unknown' }}
                            </span>

                        </div>
                    </td>

                    <td style="color:#94a3b8;font-size:12px;">
                        {{ $ticket->category->name ?? 'Uncategorized' }}
                    </td>

                    <td class="text-center">
                        <span class="px-3 py-1 rounded-pill"
                              style="background:{{ $sc[$ticket->status] ?? 'rgba(255,255,255,0.05)' }};
                                     color:{{ $st[$ticket->status] ?? '#94a3b8' }};
                                     font-size:11px;font-weight:500;">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </td>

                    <td class="text-center">
                        <span class="px-3 py-1 rounded-pill"
                              style="background:{{ $pc[$ticket->priority] ?? 'rgba(255,255,255,0.05)' }};
                                     color:{{ $pt[$ticket->priority] ?? '#94a3b8' }};
                                     font-size:11px;font-weight:500;">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </td>

                    <td class="text-center px-4">
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}"
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
                        No tickets found.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    @if($tickets->hasPages())
        <div class="px-4 py-3"
             style="border-top:1px solid rgba(255,255,255,0.05);">
            {{ $tickets->links() }}
        </div>
    @endif

</div>

<style>
    input::placeholder {
        color: #475569 !important;
    }
</style>

@endsection