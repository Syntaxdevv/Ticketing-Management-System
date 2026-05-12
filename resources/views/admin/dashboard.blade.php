@extends('layouts.master')

@section('title', 'Admin Overview')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h5 class="text-white fw-semibold mb-1">Admin Dashboard</h5>
        <p class="text-muted mb-0" style="font-size:12px;">Real-time ticketing analytics and performance tracking.</p>
    </div>
    <span class="px-3 py-2 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);font-size:12px;color:#64748b;">
        <i class="ri-calendar-line me-1"></i> {{ date('F d, Y') }}
    </span>
</div>

{{-- Stats Cards --}}
@php
$cards = [
    ['Total Tickets', $stats['total'],    'ri-ticket-2-line',       '#818cf8', 'rgba(99,102,241,0.15)'],
    ['Open Issues',   $stats['open'],     'ri-door-open-line',      '#38bdf8', 'rgba(14,165,233,0.15)'],
    ['Resolved',      $stats['resolved'], 'ri-checkbox-circle-line','#34d399', 'rgba(16,185,129,0.15)'],
    ['Total Agents',  $stats['agents'],   'ri-user-star-line',      '#fbbf24', 'rgba(245,158,11,0.15)'],
];
@endphp

<div class="row g-2 mb-3">
    @foreach($cards as $card)
    <div class="col-md-3">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:{{ $card[4] }};color:{{ $card[3] }};font-size:18px;">
                <i class="{{ $card[2] }}"></i>
            </div>
            <div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:2px;">{{ $card[0] }}</div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">{{ $card[1] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Full Width Chart --}}
<div class="rounded-3 overflow-hidden mb-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
    <div class="px-4 py-2" style="border-bottom:1px solid rgba(255,255,255,0.06);">
        <span class="text-white fw-semibold" style="font-size:13px;">
            <i class="ri-line-chart-line me-2" style="color:#818cf8;"></i>Ticket Volume Trend
        </span>
    </div>
    <div class="p-3">
        <div style="height:200px;width:100%;">
            <canvas id="ticketChart"></canvas>
        </div>
    </div>
</div>

{{-- Bottom 3 Cards --}}
<div class="row g-2">

    {{-- Top Agent --}}
    <div class="col-md-4">
        <div class="rounded-3 p-3 h-100" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:10px;">
                <i class="ri-medal-line me-1" style="color:#fbbf24;"></i>Top Performing Agents
            </div>
            @forelse($topAgents as $index => $agent)
            <div class="d-flex align-items-center justify-content-between {{ !$loop->last ? 'mb-2 pb-2' : '' }}"
                 style="{{ !$loop->last ? 'border-bottom:1px solid rgba(255,255,255,0.05)' : '' }}">
                <div class="d-flex align-items-center gap-2">
                    <div class="position-relative">
                        <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
                             style="width:32px;height:32px;background:linear-gradient(135deg,#6366f1,#8b5cf6);font-size:12px;">
                            {{ strtoupper(substr($agent->name, 0, 1)) }}
                        </div>
                        @if($index == 0)
                            <div style="position:absolute;top:-5px;right:-5px;font-size:11px;">🥇</div>
                        @elseif($index == 1)
                            <div style="position:absolute;top:-5px;right:-5px;font-size:11px;">🥈</div>
                        @elseif($index == 2)
                            <div style="position:absolute;top:-5px;right:-5px;font-size:11px;">🥉</div>
                        @endif
                    </div>
                    <div>
                        <div class="text-white fw-semibold" style="font-size:12px;">{{ $agent->name }}</div>
                        <div style="font-size:10px;color:#475569;">{{ $agent->email }}</div>
                    </div>
                </div>
                <span class="px-2 py-1 rounded-pill" style="background:rgba(16,185,129,0.15);color:#34d399;font-size:10px;font-weight:500;">
                    {{ $agent->resolved_count }} Solved
                </span>
            </div>
            @empty
            <div class="text-center py-2" style="color:#475569;font-size:12px;">
                <i class="ri-user-star-line d-block mb-1 fs-5"></i>
                No data yet.
            </div>
            @endforelse
        </div>
    </div>

    {{-- Resolution Rate --}}
    <div class="col-md-4">
        <div class="rounded-3 p-3 h-100" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:10px;">
                <i class="ri-bar-chart-line me-1" style="color:#34d399;"></i>Resolution Rate
            </div>
            @php
                $rate = $stats['total'] > 0 ? round(($stats['resolved'] / $stats['total']) * 100) : 0;
            @endphp
            <div class="fw-semibold mb-1" style="font-size:32px;line-height:1;color:#34d399;">{{ $rate }}%</div>
            <div style="font-size:11px;color:#475569;margin-bottom:10px;">{{ $stats['resolved'] }} out of {{ $stats['total'] }} tickets resolved</div>
            <div style="height:5px;background:rgba(255,255,255,0.06);border-radius:3px;">
                <div style="height:5px;border-radius:3px;background:linear-gradient(90deg,#10b981,#34d399);width:{{ $rate }}%;"></div>
            </div>
            <div class="d-flex justify-content-between mt-1" style="font-size:10px;color:#475569;">
                <span>0%</span><span>100%</span>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="col-md-4">
        <div class="rounded-3 p-3 h-100" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:10px;">
                <i class="ri-time-line me-1" style="color:#fbbf24;"></i>Quick Stats
            </div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-center justify-content-between p-2 rounded-2" style="background:#1a2235;">
                    <div style="font-size:12px;color:#94a3b8;">Open Tickets</div>
                    <span class="px-2 py-1 rounded-pill" style="background:rgba(14,165,233,0.15);color:#38bdf8;font-size:11px;font-weight:500;">{{ $stats['open'] }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-2 rounded-2" style="background:#1a2235;">
                    <div style="font-size:12px;color:#94a3b8;">Resolved</div>
                    <span class="px-2 py-1 rounded-pill" style="background:rgba(16,185,129,0.15);color:#34d399;font-size:11px;font-weight:500;">{{ $stats['resolved'] }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-2 rounded-2" style="background:#1a2235;">
                    <div style="font-size:12px;color:#94a3b8;">Total Agents</div>
                    <span class="px-2 py-1 rounded-pill" style="background:rgba(245,158,11,0.15);color:#fbbf24;font-size:11px;font-weight:500;">{{ $stats['agents'] }}</span>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('ticketChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData->pluck('month')) !!},
                    datasets: [{
                        label: 'Tickets Created',
                        data: {!! json_encode($chartData->pluck('count')) !!},
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99,102,241,0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a2235',
                            borderColor: 'rgba(255,255,255,0.08)',
                            borderWidth: 1,
                            titleColor: '#f1f5f9',
                            bodyColor: '#94a3b8',
                            padding: 10,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255,255,255,0.04)', drawBorder: false },
                            ticks: { color: '#475569', font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#475569', font: { size: 11 } }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush

@endsection