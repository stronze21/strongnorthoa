<?php

namespace App\Http\Livewire\Report;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\CookingShow;
use Livewire\WithPagination;
use App\Http\Controllers\BookedShowsController;

class AdminCookedShows extends Component
{
    use WithPagination;
    public $from_date, $to_date, $search, $page_no = 20;

    public function render()
    {
        $from = Carbon::parse($this->from_date)->startOfDay()->format('Y-m-d');
        $to = Carbon::parse($this->to_date)->endOfDay()->format('Y-m-d');

        $shows = CookingShow::where(function($query){
                $query->where('host', 'LIKE', '%' . $this->search . '%')
                ->orWhere('lifechanger', 'LIKE', '%' . $this->search . '%');
                })
            ->whereRaw('(result = "Closed" OR result = "For Follow Up")')
            ->whereBetween('date', [$from, $to])
            ->orderBy('date', 'DESC')
            ->orderBy('time', 'ASC');

        if ($this->page_no != 999) {
            $shows = $shows->paginate($this->page_no);
        } else {
            $shows = $shows->get();
        }

        return view('livewire.report.admin-cooked-shows', [
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
