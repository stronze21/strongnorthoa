<?php

namespace App\Http\Livewire\Shows;

use App\Exports\CSExport;
use App\Models\Contest;
use Livewire\Component;
use App\Models\CookingShow;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;

class CookingShows extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $show = false, $selected_cs, $contest_id, $start_rep, $end_rep;

    public function render()
    {
        $dt = Carbon::now();
        $this->start_rep = $dt->startOfMonth()->format('Y-m-d');
        $this->end_rep = $dt->endOfMonth()->format('Y-m-d');
        $contests = Contest::where('strict', 1)->whereRaw(DB::raw("'".date('Y-m-d')."' BETWEEN start_date AND end_date"))->get();
        return view('livewire.shows.cooking-shows', [
            'data' => CookingShow::orderByDesc('date')->paginate(20),
            'contests' => $contests
        ]);
    }

    public function show_cs(CookingShow $cs)
    {
        $this->show = true;
        $this->selected_cs = $cs;
    }

    public function hide_cs()
    {
        $this->show = false;
        $this->selected_cs = null;
    }

    public function save()
    {
        // $this->validate(['contest_id' => 'nullable']);
        $this->selected_cs->contest_id = $this->contest_id;
        if($this->selected_cs->save()){
            $this->dispatchBrowserEvent('success', 'Cooking Show bound to cotest');
            $this->hide_cs();
        }else{
            $this->dispatchBrowserEvent('error', 'Bind error!!!');
        }
    }

    public function export()
    {
        return Excel::download(new CSExport($this->start_rep, $this->end_rep), 'CookingShows.xlsx');
    }
}
