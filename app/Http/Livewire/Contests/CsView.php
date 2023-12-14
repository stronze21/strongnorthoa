<?php

namespace App\Http\Livewire\Contests;

use Carbon\Carbon;
use App\Models\Contest;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CsView extends Component
{
    public $contest_id, $dt, $search;

    public function render()
    {
        $this->dt = Carbon::now();
        $contest = Contest::find($this->contest_id);
        $start = $this->dt->create($contest->start_date)->format('Y-m-d');
        $end = $this->dt->create($contest->end_date)->format('Y-m-d');
        if(!$contest->strict){
            $query = "SELECT lifechanger, COUNT(cs.cs_id) as 'shows',
                            (SELECT SUM(rs.amount) FROM results as rs WHERE rs.cs_id = cs.cs_id) as 'sales',
                            (SELECT SUM(rs.amount)/320000 FROM results as rs WHERE rs.cs_id = cs.cs_id) as 'sets', cs.contest_id
                        FROM `cooking_shows` as cs
                        WHERE (cs.date BETWEEN '$start' AND '$end') AND (cs.contest_id IS NULL OR cs.contest_id = '') AND (cs.result <> 'Reschedule' OR cs.result <> 'Cancelled') AND lifechanger LIKE '%$this->search%'
                        GROUP BY cs.lifechanger ORDER BY sales DESC, sets DESC, shows DESC;";
        }else{
            $query = "SELECT lifechanger, COUNT(cs.cs_id) as 'shows',
                            (SELECT SUM(rs.amount) FROM results as rs WHERE rs.cs_id = cs.cs_id) as 'sales',
                            (SELECT SUM(rs.amount)/320000 FROM results as rs WHERE rs.cs_id = cs.cs_id) as 'sets', cs.contest_id
                        FROM `cooking_shows` as cs
                        WHERE (cs.date BETWEEN '$start' AND '$end') AND cs.contest_id = '$contest->id' AND (cs.result <> 'Reschedule' OR cs.result <> 'Cancelled') AND lifechanger LIKE '%$this->search%'
                        GROUP BY cs.lifechanger ORDER BY sales DESC, sets DESC, shows DESC;";
        }

        $data = DB::select(DB::raw($query));
        // dd($data);
        return view('livewire.contests.cs-view', [
            'data' => collect($data),
            'contest' => $contest,
        ]);
    }

    public function mount($contest_id)
    {
        $this->contest_id = $contest_id;
    }
}
