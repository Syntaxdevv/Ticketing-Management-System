<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;



class TicketController extends Controller
{
  public function index(Request $request)
{
    $query = Ticket::with(['user', 'category']);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
              ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$search}%")); // ← dagdag lang ito
        });
    }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        $tickets = $query->latest()->paginate(15);

        $categories = Category::where('is_active', true)->get();
        $users = User::where('role', 'customer')->get();

        return view('admin.content.tickets.index', compact('tickets', 'categories', 'users'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'category', 'comments.user']);
        return view('admin.content.tickets.show', compact('ticket'));
    }

    public function assign(Request $request, Ticket $ticket)
{
    $request->validate([
        'assigned_to' => 'nullable|exists:users,id'
    ]);

    $ticket->update([
        'assigned_to' => $request->assigned_to
    ]);

    return back()->with('success', 'Ticket assigned successfully!');
}

public function updateStatus(Request $request, Ticket $ticket)
{
    if (!in_array(Auth::user()->role, ['admin', 'agent'])) {
        abort(403);
    }
    
    $request->validate([
        'status' => 'required|in:open,in-progress,resolved,closed',
        'priority' => 'required|in:low,medium,high',
    ]);

    $ticket->update($request->only(['status', 'priority']));

    $ticket->comments()->create([
        'user_id' => Auth::id(),
        'message' => 'Status changed to: ' . ucfirst(str_replace('-', ' ', $request->status)) .
                     '. Priority: ' . ucfirst($request->priority),
    ]);

    return back()->with('success', 'Ticket updated successfully!');
}
public function deleteComment(Ticket $ticket, Comment $comment)
{
    if (!in_array(Auth::user()->role, ['admin', 'agent'])) {
        abort(403);
    }

    if ($comment->ticket_id !== $ticket->id) {
        abort(404);
    }

    $comment->delete();

    return back()->with('success', 'Comment deleted successfully.');
}
}
