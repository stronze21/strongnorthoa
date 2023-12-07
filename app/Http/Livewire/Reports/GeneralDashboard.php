<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use App\Models\CookingShow;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class GeneralDashboard extends Component
{
    public function render()
    {
        $booked_shows = CookingShow::where('result', 'Booked')
                            ->where('user_id', Auth::user()->user_id)
                            ->count();

        $expired_shows = CookingShow::where('result', 'Expired')
                            ->where('user_id', Auth::user()->user_id)
                            ->count();

        $cooked_shows = CookingShow::whereRaw('(result = "Closed" OR result = "For Follow Up")')
                            ->where('user_id', Auth::user()->user_id)
                            ->count();

        $closed_shows = CookingShow::where('result', 'Closed')
                            ->where('user_id', Auth::user()->user_id);

        $settings = Setting::first();

        return view('livewire.reports.general-dashboard', [
            'settings' => $settings,
            'booked_shows' => $booked_shows,
            'expired_shows' => $expired_shows,
            'cooked_shows' => $cooked_shows,
            'closed_shows' => $closed_shows->count(),
            'sets_sold' => $closed_shows->sum('amount_sold'),
        ]);
    }
}
