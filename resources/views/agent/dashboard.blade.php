@extends('layouts.master')

@section('title', 'Agent Dashboard')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">
            Welcome Back, {{ Auth::user()->name }}! 
        </h5>
        <p class="text-muted mb-0" style="font-size:12px;">
            Here is a quick overview of your assigned tickets.
        </p>
    </div>

    <span class="px-3 py-2 rounded-3"
          style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);font-size:12px;color:#64748b;">
        <i class="ri-calendar-line me-1"></i> {{ date('F d, Y') }}
    </span>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">

    {{-- Assigned Card --}}
    <div class="col-md-4">
        <div class="p-4 rounded-3"
             style="background:linear-gradient(135deg,#6366f1,#4338ca);border:1px solid rgba(255,255,255,0.1);">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center justify-content-center rounded-2"
                     style="width:40px;height:40px;background:rgba(255,255,255,0.15);font-size:18px;color:#fff;">
                    <i class="ri-ticket-2-line"></i>
                </div>
                <span style="font-size:10px;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:.07em;">
                    Assigned
                </span>
            </div>

            {{-- BINAGO: Nilagay ang tamang variable --}}
            <div class="text-white fw-semibold" style="font-size:28px;line-height:1;">
                {{ $assignedCount ?? 0 }}
            </div>

            <div style="font-size:10px;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:.07em;margin-top:4px;">
                Assigned to You
            </div>
            <div class="mt-3">
                <a href="{{ route('agent.tickets.index') }}"
                   class="text-decoration-none"
                   style="font-size:12px;color:rgba(255,255,255,0.7);">
                    View all <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Pending Card --}}
    <div class="col-md-4">
        <div class="p-4 rounded-3"
             style="background:#252d3d;border:1px solid rgba(245,158,11,0.2);">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center justify-content-center rounded-2"
                     style="width:40px;height:40px;background:rgba(245,158,11,0.15);font-size:18px;color:#fbbf24;">
                    <i class="ri-time-line"></i>
                </div>
                <span style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;">
                    Pending
                </span>
            </div>

            {{-- BINAGO: Pinalitan ang 0 ng variable --}}
            <div class="text-white fw-semibold" style="font-size:28px;line-height:1;">
                {{ $pendingCount ?? 0 }}
            </div>

            <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:4px;">
                Pending Action
            </div>
        </div>
    </div>

    {{-- Resolved Card --}}
    <div class="col-md-4">
        <div class="p-4 rounded-3"
             style="background:#252d3d;border:1px solid rgba(16,185,129,0.2);">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center justify-content-center rounded-2"
                     style="width:40px;height:40px;background:rgba(16,185,129,0.15);font-size:18px;color:#34d399;">
                    <i class="ri-shield-check-line"></i>
                </div>
                <span style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;">
                    Resolved
                </span>
            </div>

            {{-- BINAGO: Pinalitan ang 0 ng variable --}}
            <div class="text-white fw-semibold" style="font-size:28px;line-height:1;">
                {{ $resolvedCount ?? 0 }}
            </div>

            <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:4px;">
                Resolved by You
            </div>
        </div>
    </div>

</div>

{{-- Recent Assigned Tickets --}}
<div class="rounded-3 overflow-hidden"
     style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

    <div class="d-flex align-items-center justify-content-between px-4 py-3"
         style="border-bottom:1px solid rgba(255,255,255,0.06);">
        <span class="text-white fw-semibold" style="font-size:13px;">
            Recent Assigned Tickets
        </span>
        <a href="{{ route('agent.tickets.index') }}"
           class="text-decoration-none"
           style="font-size:12px;color:#6366f1;">
            View All →
        </a>
    </div>

    @if(isset($tickets) && $tickets->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0 align-middle" style="color:#94a3b8;">
                <thead style="background:#1a2235;font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.06em;">
                    <tr>
                        <th class="px-4 py-3 border-0 fw-normal">#ID</th>
                        <th class="py-3 border-0 fw-normal">Title</th>
                        <th class="py-3 border-0 fw-normal">User</th>
                        <th class="py-3 border-0 fw-normal text-center">Priority</th>
                        <th class="py-3 border-0 fw-normal text-center">Status</th>
                        <th class="py-3 px-4 border-0 fw-normal text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        @php
                            // Ginamit ang strtolower para sa status colors
                            $status_key = strtolower(trim($ticket->status));
                            
                            $sc = [
                                'open'        => 'rgba(14,165,233,0.15)',
                                'in progress' => 'rgba(139,92,246,0.15)',
                                'in-progress' => 'rgba(139,92,246,0.15)',
                                'resolved'    => 'rgba(16,185,129,0.15)',
                                'closed'      => 'rgba(239,68,68,0.15)'
                            ];

                            $st = [
                                'open'        => '#38bdf8',
                                'in progress' => '#a78bfa',
                                'in-progress' => '#a78bfa',
                                'resolved'    => '#34d399',
                                'closed'      => '#f87171'
                            ];
                        @endphp

                        <tr style="border-bottom:1px solid rgba(255,255,255,0.03);font-size:13px;">
                            <td class="px-4" style="color:#64748b;">#{{ $ticket->id }}</td>
                            <td style="color:#e2e8f0;font-weight:500;">{{ Str::limit($ticket->title, 30) }}</td>
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
                                <span class="px-3 py-1 rounded-pill" style="background:rgba(255,255,255,0.05); color:#94a3b8; font-size:11px;font-weight:500;">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="px-3 py-1 rounded-pill" 
                                      style="background:{{ $sc[$status_key] ?? 'rgba(255,255,255,0.05)' }};
                                             color:{{ $st[$status_key] ?? '#94a3b8' }};
                                             font-size:11px;font-weight:500;">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td class="text-center px-4">
                                <a href="{{ route('agent.tickets.show', $ticket->id) }}"
                                   class="px-3 py-1 rounded-2 text-decoration-none"
                                   style="background:rgba(99,102,241,0.15);color:#a5b4fc;font-size:12px;font-weight:500;">
                                    <i class="ri-eye-line me-1"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5" style="color:#475569;">
            <i class="ri-inbox-line d-block mb-3" style="font-size:40px;"></i>
            <div style="font-size:13px;">No new tickets assigned to you.</div>
        </div>
    @endif
</div>

@endsection