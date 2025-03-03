<?php

namespace App\Http\Livewire\Contest;

use App\Models\Contest;
use App\Models\Sspl;
use Livewire\Component;
use Livewire\WithPagination;

class ContestList extends Component
{
    use WithPagination;

    public $search = '';
    public $ssplFilter = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'ssplFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        // Check if user has permission to view all contests
        $this->authorize('viewAny', Contest::class);
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
        $ssplLevels = Sspl::all();

        $query = Contest::query()
            ->with('sspl')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->ssplFilter, function ($query) {
                $query->where('sspl_id', $this->ssplFilter);
            })
            ->when($this->statusFilter === 'active', function ($query) {
                $query->where('end_date', '>=', now()->toDateString());
            })
            ->when($this->statusFilter === 'ended', function ($query) {
                $query->where('end_date', '<', now()->toDateString());
            })
            ->when($this->statusFilter === 'upcoming', function ($query) {
                $query->where('start_date', '>', now()->toDateString());
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $contests = $query->paginate($this->perPage);

        return view('livewire.contest.contest-list', [
            'contests' => $contests,
            'ssplLevels' => $ssplLevels,
        ]);
    }
}
