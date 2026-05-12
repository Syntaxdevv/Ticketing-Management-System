<h5 class="text-white mb-4">Conversation</h5>

@forelse($comments as $comment)
    <div class="d-flex mb-4">
        <div class="flex-shrink-0">
            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 45px; height: 45px; border: 2px solid #333;">
                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
            </div>
        </div>

        <div class="flex-grow-1 ms-3">
            <div class="card border-0 shadow-sm mb-1" style="border-radius: 0 15px 15px 15px; background-color: #ffffff;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="m-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ $comment->user->name }}</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-0 text-dark" style="font-size: 0.85rem; line-height: 1.5; white-space: pre-line;">
                        {{ $comment->message }}
                    </p>
                </div>
            </div>
            <small class="ms-2"><a href="#" class="text-danger fw-bold" style="text-decoration: none; font-size: 0.75rem;">Reply</a></small>
        </div>
    </div>
@empty
    <div class="text-center py-4">
        <p class="text-muted">No conversation records found.</p>
    </div>
@endforelse