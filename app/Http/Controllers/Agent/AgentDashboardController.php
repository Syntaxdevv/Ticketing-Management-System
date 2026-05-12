<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class AgentDashboardController extends Controller
{
 public function index()
{
    $agentId = Auth::id();

    $tickets = Ticket::where('assigned_to', $agentId)
                    ->with('user')
                    ->latest()
                    ->get();

    $assignedCount = $tickets->count();

    $pendingCount = $tickets->filter(function($t) {
        $s = strtolower(trim($t->status));
        return $s == 'open' || str_contains($s, 'progress');
    })->count();


    $resolvedCount = $tickets->filter(function($t) {
        return strtolower(trim($t->status)) == 'resolved';
    })->count();

    return view('agent.dashboard', compact(
        'tickets', 
        'assignedCount', 
        'pendingCount', 
        'resolvedCount'
    ));
}
}