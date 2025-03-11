<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Contest;
use Livewire\Component;
use App\Models\CookingShow;
use App\Models\ContestLifechanger;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLifechangerProfile;

class UserDashboard extends Component
{
    public $myCookingShows;
    public $myContests;
    public $upcomingContests;
    public $cookingShowStats;
    public $contestAchievements;
    public $userProfile;
    public $totalDownlineLifechangers;
    public $totalTeamLeaderLifechangers;
    public $totalTeamBuilderLifechangers;
    public $totalDistributorLifechangers;

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
        if(Auth::user()->hasRole('admin')){
            redirect()->route('admin.dashboard');
        }
        $user = Auth::user();
        $this->userProfile = $user->profile;

        // Get user's cooking shows
        $this->myCookingShows = CookingShow::where('user_id', $user->user_id)
            ->latest()
            ->take(5)
            ->get();

        // Cooking show statistics
        $this->cookingShowStats = [
            'total' => CookingShow::where('user_id', $user->user_id)->count(),
            'booked' => CookingShow::where('user_id', $user->user_id)->where('result', 'Booked')->count(),
            'closed' => CookingShow::where('user_id', $user->user_id)->where('result', 'Closed')->count(),
            'followup' => CookingShow::where('user_id', $user->user_id)->where('result', 'For Follow Up')->count(),
        ];

        // Get contests the user is participating in
        $contestIds = ContestLifechanger::where('user_id', $user->user_id)
            ->pluck('contest_id');

        $this->myContests = Contest::whereIn('id', $contestIds)
            ->latest()
            ->take(5)
            ->get();

        // Get upcoming contests
        $this->upcomingContests = Contest::where('end_date', '>', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        // Get contest achievements
        $this->contestAchievements = ContestLifechanger::where('user_id', $user->user_id)
            ->with('contest')
            ->get()
            ->map(function ($item) {
                // You would add more logic here based on your contest achievements system
                return [
                    'contest_title' => $item->contest->title,
                    'date_joined' => $item->created_at->format('M d, Y'),
                    'status' => 'Participant',
                ];
            });


        // Get total lifechangers who listed the current user as team_leader in their profile
        $this->totalTeamLeaderLifechangers = UserLifechangerProfile::where('team_leader', $user->user_id)->count();

        // Get total lifechangers who listed the current user as team_builder in their profile
        $this->totalTeamBuilderLifechangers = UserLifechangerProfile::where('team_builder', $user->user_id)->count();

        // Get total lifechangers who listed the current user as distributor in their profile
        $this->totalDistributorLifechangers = UserLifechangerProfile::where('distributor', $user->user_id)->count();

        // Total downline lifechangers (combined total of all roles)
        $this->totalDownlineLifechangers = UserLifechangerProfile::where('team_leader', $user->user_id)
            ->orWhere('team_builder', $user->user_id)
            ->orWhere('distributor', $user->user_id)
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard.user-dashboard');
    }
}
