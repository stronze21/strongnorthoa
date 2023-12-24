<?php

namespace App\Http\Livewire\Shows;

use Livewire\Component;
use App\Models\CookingShow;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class CookedShows extends Component
{
    use WithPagination;
    public function render()
    {
        $shows = CookingShow::whereRaw('(result = "Closed" OR result = "For Follow Up")')
            ->where('user_id', Auth::user()->user_id)
            ->orderBy('date', 'DESC')
            ->orderBy('time', 'ASC')
            ->paginate(20);

        return view('livewire.shows.cooked-shows', [
            'shows' => $shows,
        ]);
    }
}