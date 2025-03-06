<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\Region;
use App\Models\Sspl;
use Livewire\Component;
use Livewire\WithPagination;

class LifechangerList extends Component
{
    use WithPagination;

    public $search = '';
    public $regionFilter = '';
    public $levelFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'regionFilter' => ['except' => ''],
        'levelFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        // Check if user has permission to view all lifechangers
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
        $regions = Region::all();
        $ssplLevels = Sspl::all();

        $query = User::query()
            ->with(['profile', 'region', 'province'])
            ->role('user')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('f_name', 'like', '%' . $this->search . '%')
                        ->orWhere('l_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('contact_no', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->regionFilter, function ($query) {
                $query->where('region_id', $this->regionFilter);
            })
            ->when($this->levelFilter, function ($query) {
                $query->whereHas('profile', function ($subquery) {
                    $subquery->where('current_level', $this->levelFilter);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $lifechangers = $query->paginate($this->perPage);

        return view('livewire.user.lifechanger-list', [
            'lifechangers' => $lifechangers,
            'regions' => $regions,
            'ssplLevels' => $ssplLevels,
        ]);
    }
}