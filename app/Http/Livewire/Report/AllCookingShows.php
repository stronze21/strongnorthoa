<?php

namespace App\Http\Livewire\Report;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\CookingShow;
use App\Models\User;
use Livewire\WithPagination;
use App\Http\Controllers\BookedShowsController;

class AllCookingShows extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $from_date, $to_date, $search, $page_no = 25;
    public $show_type = null;
    public $lifechangers = [];
    public $presenters = [];
    public $selected_lifechanger = null;
    public $selected_presenter = null;
    public $loading = false;
    public $view_mode = 'table';

    protected $queryString = [
        'search' => ['except' => ''],
        'from_date' => ['except' => ''],
        'to_date' => ['except' => ''],
        'show_type' => ['except' => ''],
        'selected_lifechanger' => ['except' => ''],
        'selected_presenter' => ['except' => ''],
        'page' => ['except' => 1],
        'page_no' => ['except' => 25],
        'view_mode' => ['except' => 'table'],
    ];

    public function render()
    {
        $this->loading = true;

        $from = $this->from_date ? Carbon::parse($this->from_date)->startOfDay()->format('Y-m-d') : null;
        $to = $this->to_date ? Carbon::parse($this->to_date)->endOfDay()->format('Y-m-d') : null;

        $showsQuery = CookingShow::query();

        // Apply search if provided
        if ($this->search) {
            $showsQuery->where(function ($query) {
                $query->where('host', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('lifechanger', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('presenter', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('host_email', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('contact_no', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('address', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('city_town', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('province', 'LIKE', '%' . $this->search . '%');
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

        // Apply lifechanger filter if provided
        if ($this->selected_lifechanger) {
            $showsQuery->where('lifechanger', $this->selected_lifechanger);
        }

        // Apply presenter filter if provided
        if ($this->selected_presenter) {
            $showsQuery->where('presenter', $this->selected_presenter);
        }

        // Order by date and time
        $showsQuery->orderBy('date', 'DESC')->orderBy('time', 'ASC');

        // Get paginated results
        $shows = $showsQuery->paginate($this->page_no);

        // Get all unique lifechangers and presenters for filters
        if (empty($this->lifechangers)) {
            $this->lifechangers = CookingShow::distinct()
                ->whereNotNull('lifechanger')
                ->where('lifechanger', '!=', '')
                ->orderBy('lifechanger')
                ->pluck('lifechanger')
                ->toArray();
        }

        if (empty($this->presenters)) {
            $this->presenters = CookingShow::distinct()
                ->whereNotNull('presenter')
                ->where('presenter', '!=', '')
                ->orderBy('presenter')
                ->pluck('presenter')
                ->toArray();
        }

        // Get summary statistics
        $totalShows = $shows->total();
        $bookedShows = CookingShow::where('result', 'Booked')
            ->when($from && $to, function ($q) use ($from, $to) {
                return $q->whereBetween('date', [$from, $to]);
            })
            ->count();
        $closedShows = CookingShow::where('result', 'Closed')
            ->when($from && $to, function ($q) use ($from, $to) {
                return $q->whereBetween('date', [$from, $to]);
            })
            ->count();
        $canceledShows = CookingShow::where('result', 'Canceled')
            ->when($from && $to, function ($q) use ($from, $to) {
                return $q->whereBetween('date', [$from, $to]);
            })
            ->count();

        $this->loading = false;

        $stats = [
            'total' => $totalShows,
            'booked' => $bookedShows,
            'closed' => $closedShows,
            'canceled' => $canceledShows,
        ];

        return view('livewire.report.all-cooking-shows', [
            'shows' => $shows,
            'stats' => $stats,
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

    public function updatedSelectedLifechanger()
    {
        $this->resetPage();
    }

    public function updatedSelectedPresenter()
    {
        $this->resetPage();
    }

    public function updatedPageNo()
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
            case 'all_time':
                $this->from_date = null;
                $this->to_date = null;
                break;
            default:
                break;
        }

        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'show_type', 'selected_lifechanger', 'selected_presenter']);
        $this->from_date = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->to_date = Carbon::now()->endOfWeek()->format('Y-m-d');
        $this->resetPage();
    }

    public function toggleViewMode($mode)
    {
        $this->view_mode = $mode;
    }

    public function export($format)
    {
        // This would be handled by DataTables in the frontend,
        // but we could add server-side export functionality here in the future
        $this->dispatchBrowserEvent('export-' . $format);
    }
}