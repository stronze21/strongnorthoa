<?php

namespace App\Http\Livewire\Report;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\CookingShow;
use Livewire\WithPagination;
use App\Http\Controllers\BookedShowsController;

class AllCookingShows extends Component
{
    use WithPagination;

    public $from_date, $to_date, $search, $page_no = 25;
    public $show_type = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'from_date' => ['except' => ''],
        'to_date' => ['except' => ''],
        'show_type' => ['except' => ''],
    ];

    public function render()
    {
        $from = $this->from_date ? Carbon::parse($this->from_date)->startOfDay()->format('Y-m-d') : null;
        $to = $this->to_date ? Carbon::parse($this->to_date)->endOfDay()->format('Y-m-d') : null;

        $showsQuery = CookingShow::query();

        // Apply search if provided
        if ($this->search) {
            $showsQuery->where(function($query) {
                $query->where('host', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('host_lastname', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('lifechanger', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('presenter', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('host_email', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('contact_no', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('address', 'LIKE', '%' . $this->search . '%');
            });
        }

        // Apply date range if provided
        if ($from && $to) {
            $showsQuery->whereBetween('date', [$from, $to]);
        } else if ($from) {
            $showsQuery->where('date', '>=', $from);
        } else if ($to) {
            $showsQuery->where('date', '<=', $to);
        }

        // Apply show type filter if provided
        if ($this->show_type) {
            $showsQuery->where('result', $this->show_type);
        }

        // Order by date and time
        $showsQuery->orderBy('date', 'DESC')->orderBy('time', 'ASC');

        // Get paginated results
        $shows = $showsQuery->paginate($this->page_no);

        return view('livewire.report.all-cooking-shows', [
            'shows' => $shows,
        ]);
    }

    public function mount()
    {
        // Default to current week if no dates specified
        if (!$this->from_date) {
            $this->from_date = Carbon::now()->startOfWeek()->format('Y-m-d');
        }

        if (!$this->to_date) {
            $this->to_date = Carbon::now()->endOfWeek()->format('Y-m-d');
        }

        // Check for expired shows
        BookedShowsController::expire_shows();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedShowType()
    {
        $this->resetPage();
    }

    public function updatedFromDate()
    {
        $this->resetPage();
    }

    public function updatedToDate()
    {
        $this->resetPage();
    }

    public function setDateRange($range)
    {
        switch ($range) {
            case 'today':
                $this->from_date = Carbon::today()->format('Y-m-d');
                $this->to_date = Carbon::today()->format('Y-m-d');
                break;
            case 'yesterday':
                $this->from_date = Carbon::yesterday()->format('Y-m-d');
                $this->to_date = Carbon::yesterday()->format('Y-m-d');
                break;
            case 'this_week':
                $this->from_date = Carbon::now()->startOfWeek()->format('Y-m-d');
                $this->to_date = Carbon::now()->endOfWeek()->format('Y-m-d');
                break;
            case 'last_week':
                $this->from_date = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
                $this->to_date = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');
                break;
            case 'this_month':
                $this->from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
                $this->to_date = Carbon::now()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $this->from_date = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->to_date = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'this_year':
                $this->from_date = Carbon::now()->startOfYear()->format('Y-m-d');
                $this->to_date = Carbon::now()->endOfYear()->format('Y-m-d');
                break;
            default:
                break;
        }

        $this->resetPage();
    }
}