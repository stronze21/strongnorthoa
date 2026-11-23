<?php

namespace App\Http\Livewire\Shows;

use App\Models\CookingShow;
use Carbon\Carbon;
use Livewire\Component;

class FullCalendar extends Component
{
    public $month;

    protected $queryString = ['month'];

    public function mount()
    {
        $this->normalizeMonth();
    }

    private function normalizeMonth()
    {
        if (!is_string($this->month) || !preg_match('/^(\d{4})-(0[1-9]|1[0-2])$/', $this->month)
            || (int) substr($this->month, 0, 4) < 1900 || (int) substr($this->month, 0, 4) > 2100) {
            $this->month = now()->format('Y-m');
        }
    }

    public function previousMonth()
    {
        $this->normalizeMonth();
        $this->month = Carbon::parse($this->month . '-01')->subMonth()->format('Y-m');
    }

    public function nextMonth()
    {
        $this->normalizeMonth();
        $this->month = Carbon::parse($this->month . '-01')->addMonth()->format('Y-m');
    }

    public function today()
    {
        $this->month = now()->format('Y-m');
    }

    public function render()
    {
        $this->normalizeMonth();
        $calendarMonth = Carbon::parse($this->month . '-01');
        $start = $calendarMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $end = $calendarMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);
        $shows = CookingShow::query()
            ->when(!auth()->user()->hasRole('admin'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('date')->orderBy('time')->get()
            ->groupBy(function ($show) { return $show->date->format('Y-m-d'); });

        $days = [];
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            $days[] = $day->copy();
        }

        return view('livewire.shows.full-calendar', compact('calendarMonth', 'days', 'shows'));
    }
}

