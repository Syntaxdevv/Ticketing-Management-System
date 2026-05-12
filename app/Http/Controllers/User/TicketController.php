<?php

namespace App\Http\Controllers\User;

use App\Models\Ticket;
use App\Models\Category;
use App\Http\Requests\StoreTicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{

    public function index()
    {
        $tickets = Ticket::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.content.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('user.content.tickets.create', compact('categories'));
    }


    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'open';

        $imagePaths = [];
        if ($request->hasFile('images')) {
            Storage::disk('public')->makeDirectory('tickets/images');
            foreach ($request->file('images') as $image) {
                $path = $image->store('tickets/images', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        }

        Ticket::create($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully!');
    }


    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $ticket->load(['category', 'user', 'comments.user']);
        return view('user.content.tickets.show', compact('ticket'));
    }

    public function reopen(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($ticket->status, ['resolved', 'closed'])) {
            return back()->with('error', 'Only resolved or closed tickets can be reopened.');
        }

        $ticket->update([
            'status' => 'open',
            'reopened_at' => now(),
            'rating' => null,
            'feedback_comment' => null,
        ]);

        $ticket->comments()->create([
            'user_id' => Auth::id(),
            'message' => '🚨 Ticket has been reopened by the customer.',
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket has been reopened.');
    }

    public function feedback(Request $request, Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|in:excellent,good,average,poor',
            'feedback_comment' => 'nullable|string|max:1000',
        ]);

        $ticket->update([
            'rating' => $request->rating,
            'feedback_comment' => $request->feedback_comment,
        ]);

        $ticket->comments()->create([
            'user_id' => Auth::id(),
            'message' => '⭐ Customer feedback: ' . ucfirst($request->rating),
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Thank you for your feedback!');
    }

    public function destroy(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        if ($ticket->status !== 'open') {
            return back()->with('error', 'This ticket can no longer be deleted.');
        }

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }
}