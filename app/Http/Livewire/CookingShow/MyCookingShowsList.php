<?php

namespace App\Http\Livewire\CookingShow;

use Carbon\Carbon;
use App\Models\Contest;
use Livewire\Component;
use App\Models\CookingShow;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MyCookingShowsList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $contestFilter = '';
    public $from_date, $to_date, $dateRange = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'contestFilter' => ['except' => ''],
        'dateRange' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $from = $this->from_date ? Carbon::parse($this->from_date)->startOfDay()->format('Y-m-d') : null;
        $to = $this->to_date ? Carbon::parse($this->to_date)->endOfDay()->format('Y-m-d') : null;

        $contests = Contest::all();
        $userId = Auth::id();

        $query = CookingShow::query()
            ->where('user_id', $userId)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('host', 'like', '%' . $this->search . '%')
                        ->orWhere('host_surename', 'like', '%' . $this->search . '%')
                        ->orWhere('address', 'like', '%' . $this->search . '%')
                        ->orWhere('city_town', 'like', '%' . $this->search . '%')
                        ->orWhere('province', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('result', $this->statusFilter);
            })
            ->when($this->contestFilter, function ($query) {
                $query->where('contest_id', $this->contestFilter);
            })
            ->when($this->to_date, function ($query) use ($from, $to) {
                // Parse date range and add to query
                $query->whereBetween('created_at', [$from, $to]);
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $cookingShows = $query->paginate($this->perPage);

        return view('livewire.cooking-show.my-cooking-shows-list', [
            'cookingShows' => $cookingShows,
            'contests' => $contests,
            'statuses' => $this->getStatusOptions(),
        ]);
    }

    public function getStatusOptions()
    {
        return [
            'Booked' => 'Booked',
            'Closed' => 'Closed',
            'For Follow Up' => 'For Follow Up',
            'Reschedule' => 'Reschedule',
            'Cancelled' => 'Cancelled',
        ];
    }
}
