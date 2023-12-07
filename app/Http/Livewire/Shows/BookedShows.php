<?php

namespace App\Http\Livewire\Shows;

use App\Http\Controllers\BookedShowsController;
use Livewire\Component;
use App\Models\CookingShow;
use Illuminate\Support\Facades\Auth;

class BookedShows extends Component
{
    public function render()
    {
        $shows = CookingShow::where('result', '<>', 'Closed')
                            ->where('result', '<>', 'For Follow Up')
                            ->where('user_id', Auth::user()->user_id)
                            ->orderBy('date', 'DESC')
                            ->orderBy('time', 'ASC')
                            ->paginate(20);

        return view('livewire.shows.booked-shows', [
            'shows' => $shows,
        ]);
    }

    public function mount()
    {
        BookedShowsController::expire_shows();
    }
}
