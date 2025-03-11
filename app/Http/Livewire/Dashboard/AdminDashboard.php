<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contest;
use Livewire\Component;
use App\Models\CookingShow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminDashboard extends Component
{
    use AuthorizesRequests;

    public $totalUsers;
    public $totalContests;
    public $totalCookingShows;
    public $recentUsers;
    public $recentContests;
    public $recentCookingShows;
    public $cookingShowsByStatus;
    public $monthlyStats;

    // Date filter properties
    public $startDate;
    public $endDate;
    public $selectedDateRange = 'current_month';
    public $dateRanges = [
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'current_week' => 'Current Week',
        'last_week' => 'Last Week',
        'current_month' => 'Current Month',
        'last_month' => 'Last Month',
        'current_year' => 'Current Year',
        'last_year' => 'Last Year',
        'custom' => 'Custom Range',
    ];

    public function mount()
    {
        if(Auth::user()->hasRole('user')){
            redirect()->route('dashboard');
        }
        $this->setDateRange($this->selectedDateRange);
        $this->loadDashboardData();
    }

    public function setDateRange($range)
    {
        $this->selectedDateRange = $range;

        switch ($range) {
            case 'today':
                $this->startDate = Carbon::today()->format('Y-m-d');
                $this->endDate = Carbon::today()->format('Y-m-d');
                break;
            case 'yesterday':
                $this->startDate = Carbon::yesterday()->format('Y-m-d');
                $this->endDate = Carbon::yesterday()->format('Y-m-d');
                break;
            case 'current_week':
                $this->startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
                $this->endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
                break;
            case 'last_week':
                $this->startDate = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
                $this->endDate = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');
                break;
            case 'current_month':
                $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'current_year':
                $this->startDate = Carbon::now()->startOfYear()->format('Y-m-d');
                $this->endDate = Carbon::now()->endOfYear()->format('Y-m-d');
                break;
            case 'last_year':
                $this->startDate = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');
                $this->endDate = Carbon::now()->subYear()->endOfYear()->format('Y-m-d');
                break;
        }
    }

    public function updatedSelectedDateRange()
    {
        $this->setDateRange($this->selectedDateRange);
        $this->loadDashboardData();
    }

    public function updatedStartDate()
    {
        $this->selectedDateRange = 'custom';
        $this->loadDashboardData();
    }

    public function updatedEndDate()
    {
        $this->selectedDateRange = 'custom';
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // User count is not filtered by date
        $this->totalUsers = User::count();

        // Filter contests by date range
        $this->totalContests = Contest::whereBetween(DB::raw('DATE(start_date)'), [$this->startDate, $this->endDate])->orwhereBetween(DB::raw('DATE(end_date)'), [$this->startDate, $this->endDate])->count();

        // Filter cooking shows by date range
        $this->totalCookingShows = CookingShow::whereBetween(DB::raw('DATE(created_at)'), [$this->startDate, $this->endDate])->count();

        // Recent data with date filtering
        $this->recentUsers = User::whereBetween(DB::raw('DATE(created_at)'), [$this->startDate, $this->endDate])
            ->latest()
            ->take(5)
            ->get();

        $this->recentContests = Contest::whereBetween(DB::raw('DATE(created_at)'), [$this->startDate, $this->endDate])
            ->latest()
            ->take(5)
            ->get();

        $this->recentCookingShows = CookingShow::whereBetween(DB::raw('DATE(created_at)'), [$this->startDate, $this->endDate])
            ->latest()
            ->take(5)
            ->get();

        // Get cooking shows by status
        $this->cookingShowsByStatus = CookingShow::select('result', DB::raw('count(*) as count'))
            ->whereBetween(DB::raw('DATE(date)'), [$this->startDate, $this->endDate])
            ->groupBy('result')
            ->get()
            ->pluck('count', 'result')
            ->toArray();

        // Get monthly stats based on the selected year
        $selectedYear = Carbon::parse($this->startDate)->year;

        $this->monthlyStats = CookingShow::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('count(*) as count')
        )
            ->whereYear('date', $selectedYear)
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