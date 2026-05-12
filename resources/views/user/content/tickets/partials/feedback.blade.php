@if(in_array($ticket->status, ['resolved', 'closed']))
<div class="mt-4 rounded-3 overflow-hidden" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">

    <div class="px-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">
        <span class="text-white fw-semibold" style="font-size:13px;">
            {{ $ticket->rating ? 'Your Previous Feedback' : 'Rate Your Experience' }}
        </span>
    </div>

    <div class="p-4">

        @if($ticket->rating)
            {{-- Already rated --}}
            <div class="text-center py-3">
                <p class="text-white fw-semibold mb-3">Thank you for your feedback!</p>
                @php
                    $rc = ['excellent'=>'rgba(16,185,129,0.2)','good'=>'rgba(99,102,241,0.2)','average'=>'rgba(245,158,11,0.2)','poor'=>'rgba(239,68,68,0.2)'];
                    $rt = ['excellent'=>'#34d399','good'=>'#a5b4fc','average'=>'#fbbf24','poor'=>'#f87171'];
                @endphp
                <span class="px-4 py-2 rounded-pill fw-semibold" style="background:{{ $rc[$ticket->rating] ?? 'rgba(255,255,255,0.05)' }};color:{{ $rt[$ticket->rating] ?? '#94a3b8' }};font-size:14px;">
                    {{ ucfirst($ticket->rating) }}
                </span>

                @if($ticket->feedback_comment)
                <div class="mt-3 p-3 rounded-3 text-start" style="background:#1a2235;color:#94a3b8;font-size:13px;">
                    <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;margin-bottom:6px;">Comment</div>
                    {{ $ticket->feedback_comment }}
                </div>
                @endif

                <div class="mt-4">
                    <button type="button" class="btn px-4 fw-semibold"
                        style="background:rgba(250,204,21,0.1);color:#fde047;border:1px solid rgba(250,204,21,0.2);border-radius:8px;font-size:13px;"
                        data-bs-toggle="modal" data-bs-target="#confirmModal"
                        data-action="reopen" data-title="Reopen Ticket?"
                        data-message="Are you sure you want to reopen this ticket? It will be moved back to Open status."
                        data-form-action="{{ route('tickets.reopen', $ticket) }}" data-method="POST">
                        <i class="ri-refresh-line me-1"></i> Not Satisfied – Reopen Ticket Again
                    </button>
                </div>
            </div>

        @else
            {{-- Fresh feedback form --}}
            <form action="{{ route('tickets.feedback', $ticket) }}" method="POST">
                @csrf

                <div class="text-center mb-4">
                    <p class="text-white fw-semibold mb-4" style="font-size:14px;">How satisfied are you with the resolution?</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        @foreach([
                            ['val'=>'excellent','label'=>'Excellent 😊','bg'=>'rgba(16,185,129,0.15)','color'=>'#34d399','border'=>'rgba(16,185,129,0.3)'],
                            ['val'=>'good',     'label'=>'Good 🙂',     'bg'=>'rgba(99,102,241,0.15)','color'=>'#a5b4fc','border'=>'rgba(99,102,241,0.3)'],
                            ['val'=>'average',  'label'=>'Average 😐',  'bg'=>'rgba(245,158,11,0.15)','color'=>'#fbbf24','border'=>'rgba(245,158,11,0.3)'],
                            ['val'=>'poor',     'label'=>'Poor 😞',     'bg'=>'rgba(239,68,68,0.15)', 'color'=>'#f87171','border'=>'rgba(239,68,68,0.3)'],
                        ] as $r)
                        <div>
                            <input type="radio" class="btn-check" name="rating" value="{{ $r['val'] }}" id="r_{{ $r['val'] }}" required>
                            <label for="r_{{ $r['val'] }}" class="btn px-4 py-2 fw-semibold" style="background:{{ $r['bg'] }};color:{{ $r['color'] }};border:1px solid {{ $r['border'] }};border-radius:10px;font-size:13px;">
                                {{ $r['label'] }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <label class="mb-2" style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.07em;">Additional Comments (optional)</label>
                    <textarea name="feedback_comment" rows="3" class="form-control"
                        placeholder="Tell us more so we can improve..."
                        style="background:#1a2235;border:1px solid rgba(255,255,255,0.08);color:#e2e8f0;border-radius:10px;resize:none;font-size:13px;"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn px-5 fw-semibold" style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;">
                        <i class="ri-send-plane-line me-1"></i> Submit Feedback
                    </button>
                </div>
            </form>
        @endif

    </div>
</div>
@endif