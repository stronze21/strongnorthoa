<?php

namespace App\Http\Livewire\Reports;

use App\Models\CookingShow;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GeneralDashboard extends Component
{
    public $from, $to;

    public function render()
    {
        $from = Carbon::parse($this->from)->startOfMonth()->format('Y-m-d');
        $to = Carbon::parse($this->to)->endOfMonth()->format('Y-m-d');

        $booked_shows = CookingShow::where('result', 'Booked')->whereBetween('date', [$from, $to]);
        $expired_shows = CookingShow::where('result', 'Expired')->whereBetween('date', [$from, $to]);
        $cooked_shows = CookingShow::whereRaw('(result = "Closed" OR result = "For Follow Up")')->whereBetween('date', [$from, $to]);
        $closed_shows = CookingShow::where('result', 'Closed')->whereBetween('date', [$from, $to]);

        if (!User::find(Auth::user()->user_id)->hasRole('admin')) {
            $booked_shows->where('user_id', Auth::user()->user_id);

            $expired_shows->where('user_id', Auth::user()->user_id);

            $cooked_shows->where('user_id', Auth::user()->user_id);

            $closed_shows->where('user_id', Auth::user()->user_id);
        }

        $settings = Setting::first();

        return view('livewire.reports.general-dashboard', [
            'settings' => $settings,
            'booked_shows' => $booked_shows->count(),
            'expired_shows' => $expired_shows->count(),
            'cooked_shows' => $cooked_shows->count(),
            'closed_shows' => $closed_shows->count(),
            'sets_sold' => $closed_shows->sum('amount_sold'),
        ]);
    }

    public function mount()
    {
        $this->from = Carbon::parse(now())->startOfMonth()->format('Y-m-d');
        $this->to = Carbon::parse(now())->endOfMonth()->format('Y-m-d');
    }
}
