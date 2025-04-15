<?php

namespace App\Http\Livewire\CookingShow;

use App\Models\CookingShow;
use App\Models\Contest;
use Livewire\Component;
use Livewire\WithPagination;

class CookingShowList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $contestFilter = '';
    public $dateRange = '';
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

    public function mount()
    {
        // Check if user has permission to view all cooking shows
    }

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
        $contests = Contest::all();

        $query = CookingShow::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('host', 'like', '%' . $this->search . '%')
                        ->orWhere('host_middlename', 'like', '%' . $this->search . '%')
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
            ->when($this->dateRange, function ($query) {
                // Parse date range and add to query
                $dates = explode(' to ', $this->dateRange);
                if (count($dates) === 2) {
                    $query->whereBetween('created_at', [$dates[0], $dates[1]]);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $cookingShows = $query->paginate($this->perPage);

        return view('livewire.cooking-show.cooking-show-list', [
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
