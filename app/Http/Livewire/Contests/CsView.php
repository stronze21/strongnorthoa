<?php

namespace App\Http\Livewire\Contests;

use Carbon\Carbon;
use App\Models\Contest;
use App\Models\User;
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
        $select = "SELECT lifechanger, COUNT(cs.cs_id) as 'shows', main.id as maid, cs.contest_id,
        (SELECT SUM(rs.amount) FROM order_agreements as oa join order_agreement_payment_histories as rs on rs.order_agreement_id = oa.id WHERE oa.id = main.id GROUP BY rs.order_agreement_id) as 'sales',
        (SELECT SUM(rs.amount)/320000 FROM order_agreements as oa join order_agreement_payment_histories as rs on rs.order_agreement_id = oa.id WHERE oa.id = main.id GROUP BY rs.order_agreement_id) as 'sets'
                    FROM `cooking_shows` as cs";
        $order_by = " GROUP BY cs.user_id ORDER BY sales DESC, sets DESC, shows DESC;";
        $join = " join order_agreements as main on cs.cs_id = main.cs_id";
        $where2 = "";

        if (!$contest->strict) {
            $where = " WHERE (cs.date BETWEEN '$start' AND '$end') AND (cs.contest_id IS NULL OR cs.contest_id = '') AND (cs.result = 'Closed') AND lifechanger LIKE '%$this->search%'";
        } else {
            $where = " WHERE (cs.date BETWEEN '$start' AND '$end') AND cs.contest_id = '$contest->id' AND (cs.result = 'Closed') AND lifechanger LIKE '%$this->search%'";
        }

        if ($contest->restriction == 'level') {
            $join = " INNER JOIN user_lifechanger_profiles as prof ON cs.user_id = prof.user_id";
            $where2 = " AND prof.current_level = '$contest->sspl_id'";
        }

        $query = $select . $join . $where . $where2 . $order_by;


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
