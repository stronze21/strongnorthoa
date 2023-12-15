<?php

namespace App\Http\Livewire\Contests;

use App\Models\Contest;
use App\Models\ContestLifechanger;
use App\Models\Sspl;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CsCreate extends Component
{
    use LivewireAlert;

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

    public function save()
    {
        $sspl_id = null;
        switch ($this->level_restriction) {
            case 'all':
            case 'specific':
                $restriction = $this->level_restriction;
                break;

            default:
                $restriction = 'level';
                $sspl_id = $this->level_restriction;
        }
        $contest = Contest::create([
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'shows' => $this->shows,
            'sales' => $this->sales,
            'sets' => $this->sets,
            'strict' => $this->strict,
            'restriction' => $restriction,
            'sspl_id' => $sspl_id,
        ]);

        if ($restriction == 'specific') {
            foreach ($this->lifechangers as $lc) {
                ContestLifechanger::create([
                    'contest_id' => $contest->id,
                    'user_id' => $lc,
                ]);
            }
        }

        $this->alert('success', 'Contest created successfully!');
    }
}
