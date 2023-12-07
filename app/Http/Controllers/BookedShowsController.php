<?php

namespace App\Http\Controllers;

use App\Models\CookingShow;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookedShowsController extends Controller
{
    public static function expire_shows()
    {
        $exp_date = Carbon::parse(now())->addHours(12);
        $expired_shows = CookingShow::where('date', '<', $exp_date)->where('result', 'Booked')->latest('date')->get();
        foreach($expired_shows as $show){
            $interval = Carbon::parse($show->date.' '.$show->time)->diff($exp_date);
            if($interval->h > 12){
                $show->result = 'Expired';
                $show->save();
            }
        }
    }
}
