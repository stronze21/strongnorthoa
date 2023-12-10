<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use App\Models\Region;
use Livewire\Component;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Sspl;
use App\Models\UserDependent;
use App\Models\UserLifechangerProfile;
use App\Models\UserWorkExperience;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LifechangerProfile extends Component
{
    use LivewireAlert;

    public $user_id;
    public $f_name, $m_name, $l_name, $birthdate;
    public $region_id, $province_id, $municipality_id, $address;
    public $contact_no, $occupation, $email, $sspl, $team_builder, $distributor;

    public $child_name, $child_dob, $child_school;
    public $exp_name, $exp_contact, $exp_salary, $exp_position, $exp_from, $exp_to;

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
        $levels = Sspl::all();

        $dependents = UserDependent::where('user_id', $user->user_id)->get();
        $works = UserWorkExperience::where('user_id', $user->user_id)->get();

        return view('livewire.profile.lifechanger-profile', compact('user', 'regions', 'provinces', 'municipalities', 'lcs', 'levels', 'dependents', 'works'));
    }

    public function mount()
    {
        $user = User::find(Auth::user()->user_id);
        $this->user_id = Auth::user()->user_id;
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

        $profile = $user->profile;
        if ($profile) {
            $this->occupation = $profile->occupation;
            $this->team_builder = $profile->team_builder;
            $this->distributor = $profile->distributor;
            $this->sspl = $profile->current_level;
        }
    }

    public function save()
    {
        $user = User::find($this->user_id);
        $user->f_name = $this->f_name;
        $user->m_name = $this->m_name;
        $user->l_name = $this->l_name;
        $user->birth_date = $this->birthdate;
        $user->region_id = $this->region_id;
        $user->province_id = $this->province_id;
        $user->municipality_id = $this->municipality_id;
        $user->address = $this->address;
        $user->contact_no = $this->contact_no;
        $user->email = $this->email;
        $user->sspl_id = $this->sspl;
        $user->save();

        $profile = UserLifechangerProfile::firstOrCreate([
            'user_id' => $user->user_id
        ]);

        $profile->occupation = $this->occupation;
        $profile->current_level = $this->sspl;
        $profile->team_builder = $this->team_builder;
        $profile->distributor = $this->distributor;
        $profile->save();

        $this->alert('success', 'Profile saved successfully!');
    }

    public function add_dependent()
    {
        UserDependent::create([
            'user_id' => $this->user_id,
            'name' => $this->child_name,
            'birth_date' => $this->child_dob,
            'school' => $this->child_school,
        ]);
        $this->reset('child_name', 'child_dob', 'child_school');
        $this->alert('success', 'Added new dependent successfully!');
    }

    public function add_experience()
    {
        dd($this->exp_to);
        UserWorkExperience::create([
            'user_id' => $this->user_id,
            'name' => $this->exp_name,
            'contact' => $this->exp_contact,
            'position' => $this->exp_position,
            'salary' => $this->exp_salary,
            'from_date' => $this->exp_from,
            'to_date' => $this->exp_to,
        ]);
        $this->reset('exp_name', 'exp_contact', 'exp_position', 'exp_salary', 'exp_from', 'exp_to');
        $this->alert('success', 'Added new work experience successfully!');
    }
}
