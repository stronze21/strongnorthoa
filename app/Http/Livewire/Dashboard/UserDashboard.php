<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Contest;
use App\Models\CookingShow;
use App\Models\ContestLifechanger;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Component
{
    public $myCookingShows;
    public $myContests;
    public $upcomingContests;
    public $cookingShowStats;
    public $contestAchievements;
    public $userProfile;

    public function mount()
    {
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
    }

    public function render()
    {
        return view('livewire.dashboard.user-dashboard');
    }
}
