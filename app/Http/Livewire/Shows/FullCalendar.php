<?php

namespace App\Http\Livewire\Shows;

use App\Models\CookingShow;
use Carbon\Carbon;
use Livewire\Component;

class FullCalendar extends Component
{
    public $month;
    public $lifechanger = '';
    public $resultFilter = '';
    public $fromDate = '';
    public $toDate = '';

    protected $queryString = ['month', 'lifechanger' => ['except' => ''], 'resultFilter' => ['except' => ''], 'fromDate' => ['except' => ''], 'toDate' => ['except' => '']];

    public function resetFilters()
    {
        $this->reset(['lifechanger', 'resultFilter', 'fromDate', 'toDate']);
        $this->resetValidation();
    }

    public function updatedFromDate()
    {
        if ($this->validDate($this->fromDate)) {
            $this->month = substr($this->fromDate, 0, 7);
        }
    }

    private function validDate($date)
    {
        return is_string($date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)
            && Carbon::hasFormat($date, 'Y-m-d');
    }

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
        $visibleShows = CookingShow::query()
            ->when(!auth()->user()->hasRole('admin'), function ($query) {
                $query->where('user_id', auth()->id());
            });
        $lifechangers = (clone $visibleShows)->whereNotNull('lifechanger')->where('lifechanger', '<>', '')
            ->distinct()->orderBy('lifechanger')->pluck('lifechanger');
        $validFrom = $this->validDate($this->fromDate);
        $validTo = $this->validDate($this->toDate);
        $periodError = (($this->fromDate && !$validFrom) || ($this->toDate && !$validTo))
            ? 'Enter valid dates for the period.'
            : (($validFrom && $validTo && $this->fromDate > $this->toDate) ? 'End date must be on or after start date.' : '');
        $shows = $visibleShows
            ->when($this->lifechanger !== '', function ($query) {
                $query->where('lifechanger', $this->lifechanger);
            })
            ->when($this->resultFilter === 'closed', function ($query) {
                $query->whereRaw('LOWER(TRIM(result)) = ?', ['closed']);
            })
            ->when($this->resultFilter === 'follow_up', function ($query) {
                $query->whereRaw("LOWER(TRIM(REPLACE(result, '-', ' '))) IN (?, ?)", ['for follow up', 'follow up']);
            })
            ->when($validFrom, function ($query) { $query->whereDate('date', '>=', $this->fromDate); })
            ->when($validTo, function ($query) { $query->whereDate('date', '<=', $this->toDate); })
            ->when($periodError !== '', function ($query) { $query->whereRaw('1 = 0'); })
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('date')->orderBy('time')->get()
            ->groupBy(function ($show) { return $show->date->format('Y-m-d'); });

        $days = [];
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            $days[] = $day->copy();
        }

        return view('livewire.shows.full-calendar', compact('calendarMonth', 'days', 'shows', 'lifechangers', 'periodError'));
    }
}

