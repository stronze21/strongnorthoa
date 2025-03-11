<?php

namespace App\Http\Livewire\Profile;

use App\Models\Sspl;
use App\Models\User;
use Livewire\Component;
use App\Models\Province;
use App\Exports\UsersExport;
use App\Models\Municipality;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Masterlist extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $f_name, $m_name, $l_name, $email, $search, $selected_user_email, $user_id;

    public $showFilters = false;
    public $filters = [
        'town' => '',
        'province' => '',
        'status' => '',
        'current_level' => '',
        'level_type' => '',
    ];
    public $columns = [
        'id' => true,
        'lifechanger' => true,
        'birthdate' => true,
        'town' => true,
        'province' => true,
        'signup_date' => true,
        'team_builder' => true,
        'team_leader' => true,
        'distributor' => true,
        'date_time_show' => true,
        'amount_invested' => true,
        'status' => true,
        'current_level' => true,
        'date_promoted' => true,
        'actions' => true,
    ];

    public $towns = [];
    public $provinces = [];
    public $levels = [];
    public $levelTypes = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFiltersLevelType($value)
    {
        $this->filters['current_level'] = ''; // Reset current level when type changes
        $this->updateLevels();
    }

    public function updateLevels()
    {
        $query = Sspl::orderBy('level');

        if (!empty($this->filters['level_type'])) {
            $query->where('type', $this->filters['level_type']);
        }

        $this->levels = $query->get();
    }

    public function render()
    {

        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('full_name', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('email', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->filters['status'], function ($query) {
                $query->where('status', $this->filters['status']);
            });

        if (!empty($this->filters['current_level'])) {
            $users->whereHas('cur_level.sspl', function ($q) {
                $q->where('id', $this->filters['current_level']);
            });
        }

        if (!empty($this->filters['level_type'])) {
            $users->whereHas('cur_level.sspl', function ($q) {
                $q->where('type', $this->filters['level_type']);
            });
        }

        if (!empty($this->filters['town'])) {
            $users->whereHas('municipality', function ($q) {
                $q->where('municipality_id', $this->filters['town']);
            });
        }

        if (!empty($this->filters['province'])) {
            $users->whereHas('municipality.province', function ($q) {
                $q->where('province_id', $this->filters['province']);
            });
        }

        return view('livewire.profile.masterlist', [
            'users' => $users->get(),
        ]);
    }


    public function mount()
    {
        $this->provinces = Province::orderBy('province_name')->get();
        $this->levelTypes = Sspl::select('type')->distinct()->pluck('type'); // Get unique types
        $this->updateLevels();
    }


    public function updatedFiltersProvince($value)
    {
        $this->towns = Municipality::where('province_id', $value)->orderBy('municipality_name')->get();
        $this->filters['town'] = ''; // Reset town when province changes
    }

    public function applyFilters()
    {
        $this->resetPage(); // Reset pagination when filters change
        $this->showFilters = false;
    }

    public function resetFilters()
    {
        $this->filters = [
            'town' => '',
            'province' => '',
            'status' => '',
            'current_level' => '',
        ];
        $this->towns = [];
    }


    public function view_lc($user_id)
    {
        return $this->redirect(route('lc.create', $user_id));
    }

    public function save_user()
    {
        $this->validate([
            'f_name' => ['required', 'string', 'max:255'],
            'm_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        User::create([
            'full_name' => $this->l_name . ', ' . $this->f_name . ' ' . $this->m_name,
            'l_name' => $this->l_name,
            'f_name' => $this->f_name,
            'm_name' => $this->m_name,
            'email' => $this->email,
            'pw' => Hash::make('strongnorth'),
        ]);
        $this->reset();
        $this->alert('success', 'New user created!');
    }

    public function delete_user()
    {
        $user = User::find($this->user_id);
        $user->delete();
        $this->alert('warning', 'User deleted!');
    }


public function exportToExcel()
{

    // Trigger the export
    return Excel::download(new UsersExport($this->columns, $this->filters), 'users_export.xlsx');
}
}