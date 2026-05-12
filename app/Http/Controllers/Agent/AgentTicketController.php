<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('assigned_to', Auth::id())
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('agent.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
       
        if ($ticket->assigned_to !== Auth::id()) {
            abort(403, 'Hindi ka awtorisado na tignan ang ticket na ito.');
        }

        return view('agent.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        if ($ticket->assigned_to !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:open,in-progress,resolved,closed'
        ]);

        $ticket->update(['status' => $request->status]);

        return back()->with('success', 'Ticket status updated successfully!');
    }
}