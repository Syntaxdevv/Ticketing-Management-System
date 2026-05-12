@extends('layouts.master')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">Dashboard</h5>
        <p class="text-muted mb-0" style="font-size:12px;">Welcome back, {{ Auth::user()->name }}. Here's what's happening.</p>
    </div>
   <a href="{{ route('tickets.create') }}" class="btn fw-semibold d-inline-flex align-items-center"
   style="background: #6366f1; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; transition: all 0.2s;">
    <i class="ri-add-line me-1" style="font-size: 16px;"></i> 
    Create New Ticket
</a>
</div>

@php
$stats = [
    ['label' => 'Total Tickets',  'val' => $totalTickets, 'icon' => 'ri-database-2-line',  'color' => '#818cf8', 'bg' => 'rgba(99,102,241,0.12)'],
    ['label' => 'Pending',        'val' => $pending,      'icon' => 'ri-time-line',         'color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.12)'],
    ['label' => 'Open',           'val' => $open,         'icon' => 'ri-broadcast-line',    'color' => '#38bdf8', 'bg' => 'rgba(14,165,233,0.12)'],
    ['label' => 'In Progress',    'val' => $inProgress,   'icon' => 'ri-loader-3-line',     'color' => '#a78bfa', 'bg' => 'rgba(139,92,246,0.12)'],
    ['label' => 'Resolved',       'val' => $resolved,     'icon' => 'ri-shield-check-line', 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.12)'],
    ['label' => 'Closed',         'val' => $closed,       'icon' => 'ri-lock-line',         'color' => '#f87171', 'bg' => 'rgba(239,68,68,0.12)'],
];
@endphp

<div class="row g-3 mb-4">
    @foreach($stats as $s)
    <div class="col-xl-4 col-md-6">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#111827;border:1px solid rgba(255,255,255,0.06);">
            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-2"
                 style="width:44px;height:44px;background:{{ $s['bg'] }};color:{{ $s['color'] }};font-size:20px;">
                <i class="{{ $s['icon'] }}"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:22px;line-height:1;">{{ $s['val'] }}</div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">{{ $s['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Recent Tickets --}}
<div class="rounded-3 overflow-hidden" style="background:#111827;border:1px solid rgba(255,255,255,0.06);">
    <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.05);">
        <span class="text-white fw-semibold" style="font-size:13px;">Recent Tickets</span>
        <a href="{{ route('tickets.index') }}" class="text-decoration-none" style="font-size:11px;color:#6366f1;">View all →</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle" style="color:#94a3b8;">
            <thead style="background:#0d1117;font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.06em;">
                <tr>
                    <th class="px-4 py-3 border-0 fw-normal">#ID</th>
                    <th class="py-3 border-0 fw-normal">Title</th>
                    <th class="py-3 border-0 fw-normal">Category</th>
                    <th class="py-3 border-0 fw-normal">Priority</th>
                    <th class="py-3 border-0 fw-normal">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTickets as $ticket)
                @php
                    $pc = ['high'=>'rgba(239,68,68,0.12)','medium'=>'rgba(245,158,11,0.12)','low'=>'rgba(16,185,129,0.12)'];
                    $pt = ['high'=>'#f87171','medium'=>'#fbbf24','low'=>'#34d399'];
                @endphp
                <tr style="border-bottom:1px solid rgba(255,255,255,0.03);font-size:12px;">
                    <td class="px-4" style="color:#475569;">#{{ $ticket->id }}</td>
                    <td>
                        <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none fw-semibold" style="color:#6366f1;">
                            {{ Str::limit($ticket->title, 35) }}
                        </a>
                    </td>
                    <td>{{ $ticket->category->name ?? 'Uncategorized' }}</td>
                    <td>
                        <span class="badge rounded-pill px-3 py-1"
                              style="background:{{ $pc[$ticket->priority] ?? 'rgba(255,255,255,0.05)' }};color:{{ $pt[$ticket->priority] ?? '#94a3b8' }};">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-1" style="background:rgba(99,102,241,0.12);color:#a5b4fc;">
                            {{ ucfirst(str_replace('-', ' ', $ticket->status)) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="color:#475569;font-size:13px;">
                        <i class="ri-inbox-archive-line d-block mb-2 fs-4"></i>
                        No tickets yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection