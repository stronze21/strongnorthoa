<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;
use App\Models\CookingShow;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookedShowsController;
use Carbon\Carbon;

class AdminBookedShows extends Component
{
    use WithPagination;

    public $from_date, $to_date, $search;

    public function render()
    {
        $from = Carbon::parse($this->from_date)->startOfDay()->format('Y-m-d');
        $to = Carbon::parse($this->to_date)->endOfDay()->format('Y-m-d');

        $shows = CookingShow::where('result', '<>', 'Closed')
            ->where('result', '<>', 'For Follow Up')
            ->where(function($query){
                $query->where('host', 'LIKE', '%' . $this->search . '%')
                ->orWhere('lifechanger', 'LIKE', '%' . $this->search . '%');
                })
            ->whereBetween('date', [$from, $to])
            ->orderBy('date', 'DESC')
            ->orderBy('time', 'ASC')
            ->paginate(20);

        return view('livewire.report.admin-booked-shows', [
            'shows' => $shows,
        ]);
    }

    public function mount()
    {
        $this->from_date = Carbon::parse(now())->startOfWeek()->format('Y-m-d');
        $this->to_date = Carbon::parse(now())->endOfWeek()->format('Y-m-d');
        BookedShowsController::expire_shows();
    }
}
