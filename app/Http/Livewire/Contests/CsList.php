<?php

namespace App\Http\Livewire\Contests;

use App\Models\Contest;
use App\Models\CookingShow;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CsList extends Component
{
    use WithPagination;

    protected $listeners = ['showCreate'];

    public $title, $description, $start_date, $end_date, $shows = 0, $sales = 0, $sets = 0, $strict = 0;

    public function render()
    {
        $data = Contest::paginate(20);

        return view('livewire.contests.cs-list',[
            'data' => $data
        ]);
    }

    public function showCreate()
    {
        $this->start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function validateNew()
    {
        return $this->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'shows' => 'nullable|numeric',
            'sales' => 'nullable|numeric',
            'sets' => 'nullable|numeric',
            'strict' => 'nullable',
        ]);
    }

    public function save()
    {
        $validatedData = $this->validateNew();
        Contest::create($validatedData);
        $this->dispatchBrowserEvent('success', 'Contest created!');
    }

    public function viewContest($contest_id)
    {
        redirect()->route('contests.view', ['contest_id' => $contest_id]);
    }
}
