<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use App\Models\Contest;
use App\Models\CookingShow;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    public $totalUsers;
    public $totalContests;
    public $totalCookingShows;
    public $recentUsers;
    public $recentContests;
    public $recentCookingShows;
    public $cookingShowsByStatus;
    public $monthlyStats;

    public function mount()
    {
        $this->totalUsers = User::count();
        $this->totalContests = Contest::count();
        $this->totalCookingShows = CookingShow::count();

        $this->recentUsers = User::latest()->take(5)->get();
        $this->recentContests = Contest::latest()->take(5)->get();
        $this->recentCookingShows = CookingShow::latest()->take(5)->get();

        // Get cooking shows by status
        $this->cookingShowsByStatus = CookingShow::select('result', DB::raw('count(*) as count'))
            ->groupBy('result')
            ->get()
            ->pluck('count', 'result')
            ->toArray();

        // Get monthly stats
        $this->monthlyStats = CookingShow::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $item->month_name = date('F', mktime(0, 0, 0, $item->month, 1));
                return $item;
            });
    }

    public function render()
    {
        return view('livewire.dashboard.admin-dashboard');
    }
}
