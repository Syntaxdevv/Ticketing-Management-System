<?php

namespace App\Http\Controllers\User;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $userTickets = Ticket::where('user_id', $userId)->get();

        $totalTickets = $userTickets->count();

        $statusCounts = $userTickets->groupBy('status')
            ->map(function ($items) {
                return count($items);
            })
            ->toArray();

        $open = $statusCounts['open'] ?? ($statusCounts['Open'] ?? 0);
        $inProgress = $statusCounts['in-progress'] ?? ($statusCounts['In Progress'] ?? 0);
        $resolved = $statusCounts['resolved'] ?? ($statusCounts['Resolved'] ?? 0);
        $closed = $statusCounts['closed'] ?? ($statusCounts['Closed'] ?? 0);
        
        $pending = $open + $inProgress;

        $recentTickets = Ticket::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'totalTickets',
            'open',
            'inProgress',
            'resolved',
            'closed',
            'pending',
            'recentTickets'
        ));
    }
}