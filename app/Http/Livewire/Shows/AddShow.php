<?php

namespace App\Http\Livewire\Shows;

use App\Models\CookingShow;
use App\Models\Sspl;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddShow extends Component
{

    use LivewireAlert;

    protected $listeners = ['reroute'];

    public $date, $time, $type;
    public $host, $host_surename, $spouse, $address, $address_2, $city_town, $province, $contact_no, $occupation, $host_email, $social_media;
    public $lifechanger, $presenter, $partner_id, $partner_type, $team_builder, $distributor, $sspl;
    public $reason1, $reason2;
    public $min_date;
    public $partners = [];

    public function render()
    {
        return view('livewire.shows.add-show');
    }

    public function mount()
    {
        $this->min_date = date('Y-m-d');
        $this->date = $this->min_date;
        $this->time = date('H:i');
        $this->type = 'Conventional';
        $this->host = null;
        $this->spouse = null;
        $this->address = null;
        $this->contact_no = null;
        $this->occupation = null;
        $this->host_email = null;
        $this->social_media = null;
        $this->lifechanger = Auth::user()->fullname();
        $this->presenter = null;
        $this->partner_id = null;
        $this->partner_type = null;
        $this->team_builder = Auth::user()->profile->builder ? Auth::user()->profile->builder->fullname() : 'N/A';
        $this->distributor = Auth::user()->profile->distrib ? Auth::user()->profile->distrib->fullname() : 'N/A';
        $this->sspl = Auth::user()->cur_level ? Auth::user()->cur_level->sspl->level : '0';
        $this->partners = User::whereHas('profile', function($query){
            $query->where('team_leader', Auth::user()->id);
        })->whereHas('cur_level', function($query){
            $query->whereHas('sspl', function($query){
                $query->where('type', 'partner');
            } );
        })->get();

        $this->reason1 = null;
        $this->reason2 = null;
    }

    public function save()
    {
        $this->validate([
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:' . $this->min_date],
            'time' => ['required'],
            'type' => ['required', 'string'],
            'host' => ['required', 'string'],
            'host_surename' => ['required', 'string'],
            'spouse' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'address_2' => ['nullable', 'string'],
            'city_town' => ['required', 'string'],
            'province' => ['required', 'string'],
            'contact_no' => ['required', 'string'],
            'occupation' => ['nullable', 'string'],
            'host_email' => ['required', 'email'],
            'social_media' => ['nullable', 'string'],
            'lifechanger' => ['required', 'string'],
            'presenter' => ['required', 'string'],
            'partner_id' => ['nullable', 'string'],
            'partner_type' => ['nullable', 'string'],
            'team_builder' => ['required', 'string'],
            'distributor' => ['required', 'string', 'string'],
            'sspl' => ['required', 'string'],
        ]);

        if($this->partner_id){
            $this->partner_type = User::find($this->partner_id)->cur_level->sspl->level;
        }

        $new_show = new CookingShow;
        $new_show->date = $this->date;
        $new_show->time = $this->time;
        $new_show->type = $this->type;
        $new_show->host = $this->host;
        $new_show->host_surename = $this->host_surename;
        $new_show->spouse = $this->spouse;
        $new_show->address = $this->address;
        $new_show->address_2 = $this->address_2;
        $new_show->city_town = $this->city_town;
        $new_show->province = $this->province;
        $new_show->contact_no = $this->contact_no;
        $new_show->occupation = $this->occupation;
        $new_show->host_email = $this->host_email;
        $new_show->social_media = $this->social_media;
        $new_show->lifechanger = $this->lifechanger;
        $new_show->presenter = $this->presenter;
        $new_show->partner_id = $this->partner_id;
        $new_show->partner_type = $this->partner_type;
        $new_show->team_builder = $this->team_builder;
        $new_show->distributor = $this->distributor;
        $new_show->sspl = $this->sspl;
        $new_show->result = 'Booked';
        $new_show->user_id = Auth::user()->user_id;
        $new_show->teams_id = Auth::user()->team;
        $new_show->date_created = now();
        $new_show->save();

        $this->alert('success', 'Cooking show booked successfully!', [
            'allowOutsideClick' => false,
            'allowEscapeKey' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'Finish',
            'onConfirmed' => 'reroute',
            'toast' => false,
            'position' => 'center',
            'timer' => 0,
        ]);
    }

    public function reroute()
    {
        $this->redirect(route('cs.booked'));
    }
}
