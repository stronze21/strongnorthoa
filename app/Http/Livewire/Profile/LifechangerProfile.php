<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use App\Models\Region;
use Livewire\Component;
use App\Models\Province;
use App\Models\Municipality;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LifechangerProfile extends Component
{
    use LivewireAlert;

    public $f_name, $m_name, $l_name, $birthdate;
    public $region_id, $province_id, $municipality_id, $address;
    public $contact_no, $occupation, $email;

    public function updatedRegionId()
    {
        $this->reset('province_id', 'municipality_id');
    }

    public function updatedProvinceId()
    {
        $this->reset('municipality_id');
    }

    public function render()
    {
        $user = User::find(Auth::user()->user_id);
        $regions = Region::all();
        $provinces = Province::where('region_id', $this->region_id)->get();
        $municipalities = Municipality::where('province_id', $this->province_id)->get();
        $lcs = User::all();

        return view('livewire.profile.lifechanger-profile', compact('user', 'regions', 'provinces', 'municipalities', 'lcs'));
    }

    public function mount()
    {
        $user = User::find(Auth::user()->user_id);
        $this->f_name = $user->f_name;
        $this->m_name = $user->m_name;
        $this->l_name = $user->l_name;
        $this->birthdate = $user->birthdate;
        $this->region_id = $user->region_id ?? '3';
        $this->province_id = $user->province_id ?? '2';
        $this->municipality_id = $user->municipality_id ?? '20';
        $this->address = $user->address;
        $this->contact_no = $user->contact_no;
        $this->email = $user->email;

        $this->occupation = $user->occupation;
    }
}