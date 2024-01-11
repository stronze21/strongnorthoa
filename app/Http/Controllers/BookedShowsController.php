<?php

namespace App\Http\Controllers;

use App\Models\CookingShow;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookedShowsController extends Controller
{
    public static function expire_shows()
    {
        $expired_shows = CookingShow::where('result', 'Booked')->latest('date')->get();
        foreach ($expired_shows as $show) {
            $interval = Carbon::parse($show->date . ' ' . $show->time)->diff(now());
            if ($interval->h >= 12 and !$interval->invert) {
                dd($interval);
                $show->result = 'Expired';
                $show->save();
            }
        }
    }
}
