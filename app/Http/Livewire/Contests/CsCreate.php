<?php

namespace App\Http\Livewire\Contests;

use App\Models\Sspl;
use App\Models\User;
use Livewire\Component;

class CsCreate extends Component
{

    public $date, $title, $description, $start_date, $end_date, $shows, $sales, $sets, $strict = 0, $level_restriction = 'all', $lifechangers = [];

    public function render()
    {
        $sspls = Sspl::all();
        $lcs = User::has('profile')->get();

        return view('livewire.contests.cs-create', compact(
            'sspls',
            'lcs',
        ));
    }
}
