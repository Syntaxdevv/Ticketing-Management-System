<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'    => Ticket::count(),
            'open'     => Ticket::where('status', 'open')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'agents'   => User::where('role', 'agent')->count(),
        ];
        $chartData = Ticket::select(
            DB::raw('count(*) as count'),
            DB::raw("DATE_FORMAT(created_at, '%M') as month")
        )
        ->groupBy('month')
        ->orderBy('created_at', 'ASC')
        ->get();

        $topAgents = User::where('role', 'agent')
            ->withCount(['assignedTickets as resolved_count' => function ($query) {
                $query->where('status', 'resolved');
            }])
            ->orderBy('resolved_count', 'desc')
            ->take(5)
            ->get();

        $recentTickets = Ticket::with(['user', 'agent'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentTickets', 'chartData', 'topAgents'));
    }
}