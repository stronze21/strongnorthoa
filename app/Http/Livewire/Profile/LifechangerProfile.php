<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use App\Models\Region;
use Livewire\Component;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Sspl;
use App\Models\UserCharacterReference;
use App\Models\UserDependent;
use App\Models\UserLifechangerProfile;
use App\Models\UserLifechangerPromotion;
use App\Models\UserWorkExperience;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LifechangerProfile extends Component
{
    use LivewireAlert;

    protected $listeners = ['update_child', 'remove_child', 'update_experience', 'remove_experience', 'update_reference', 'remove_reference', 'delete_history'];

    public $user_id;
    public $f_name, $m_name, $l_name, $birthdate;
    public $region_id, $province_id, $municipality_id, $address;
    public $contact_no, $occupation, $email, $civil_status, $birth_place, $birth_date, $spouse;

    public $sspl_id, $date_promoted, $cs_date, $amount_invested, $sign_up_date, $team_leader, $team_builder, $distributor;

    public $child_name, $child_dob, $child_school;
    public $exp_name, $exp_contact, $exp_salary, $exp_position, $exp_from, $exp_to;
    public $ref_name, $ref_rel, $ref_contact;

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
        $user = User::find($this->user_id);
        $regions = Region::all();
        $provinces = Province::where('region_id', $this->region_id)->get();
        $municipalities = Municipality::where('province_id', $this->province_id)->get();
        $lcs = User::all();
        $distribs = UserLifechangerPromotion::where('sspl_id', '4')->with('user')->get();
        $levels = Sspl::all();

        $dependents = UserDependent::where('user_id', $this->user_id)->get();
        $works = UserWorkExperience::where('user_id', $this->user_id)->get();
        $references = UserCharacterReference::where('user_id', $this->user_id)->get();
        $promotions = UserLifechangerPromotion::where('user_id', $this->user_id)->orderBy('date_promoted', 'DESC')->get();

        return view(
            'livewire.profile.lifechanger-profile',
            compact('user', 'distribs', 'regions', 'provinces', 'municipalities', 'lcs', 'levels', 'dependents', 'works', 'references', 'promotions')
        );
    }

    public function mount($userID = null)
    {
        $user_id = $userID ?? Auth::user()->user_id;
        $user = User::find($user_id);
        $this->user_id = $user_id;
        $this->f_name = $user->f_name;
        $this->m_name = $user->m_name;
        $this->l_name = $user->l_name;
        $this->region_id = $user->region_id ?? '3';
        $this->province_id = $user->province_id ?? '2';
        $this->municipality_id = $user->municipality_id ?? '20';
        $this->address = $user->address;
        $this->contact_no = $user->contact_no;
        $this->email = $user->email;

        $profile = $user->profile;
        if ($profile) {
            $this->occupation = $profile->occupation;
            $this->spouse = $profile->spouse;
            $this->birth_date = $profile->birth_date;
            $this->birth_place = $profile->birth_place;
            $this->civil_status = $profile->civil_status;
            $this->occupation = $profile->occupation;
            $this->team_builder = $profile->team_builder;
            $this->distributor = $profile->distributor;
            $this->sspl_id = $profile->current_level;
            $this->cs_date = $profile->cs_date;
            $this->amount_invested = $profile->amount_invested;
            $this->sign_up_date = $profile->sign_up_date;
            $this->team_leader = $profile->team_leader;
            $this->team_builder = $profile->team_builder;
            $this->distributor = $profile->distributor;
        }
    }

    public function save()
    {

        $validate = $this->validate([
            'f_name' => ['required', 'string', 'max:255'],
            'm_name' => ['nullable', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:' . date('Y-m-d')],
            'occupation' => ['nullable', 'string', 'max:255'],
            'spouse' => ['nullable', 'string', 'max:255'],
            'civil_status' => ['required', 'string', 'max:20'],
            'region_id' => ['required', 'exists:table_region,region_id'],
            'province_id' => ['required', 'exists:table_province,province_id'],
            'municipality_id' => ['required', 'exists:table_municipality,municipality_id'],
            'address' => ['required', 'string', 'max:255'],
            'contact_no' => ['required', 'string', 'max:13'],
            'email' => ['required', 'string', 'max:255'],
        ], [
            'f_name.required' => 'First name required...',
            'l_name.required' => 'Last name required...',
            'birth_date.required' => 'Date of birth required...',
            'region_id.required' => 'Region required...',
            'province_id.required' => 'Province required...',
            'municipality_id.required' => 'Municipality required...',
            'address.required' => 'Addres required...',
        ]);

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
        $user->save();

        $profile = UserLifechangerProfile::firstOrCreate([
            'user_id' => $user->user_id
        ]);

        $profile->spouse = $this->spouse;
        $profile->occupation = $this->occupation;
        $profile->birth_date = $this->birth_date;
        $profile->birth_place = $this->birth_place;
        $profile->civil_status = $this->civil_status;
        $profile->save();

        $this->alert('success', 'Profile saved successfully!');
    }

    public function save_profile()
    {
        $profile = UserLifechangerProfile::firstOrCreate([
            'user_id' => $this->user_id
        ]);

        $profile->cs_date = $this->cs_date;
        $profile->amount_invested = $this->amount_invested;
        $profile->sign_up_date = $this->sign_up_date;
        $profile->team_leader = $this->team_leader;
        $profile->team_builder = $this->team_builder;
        $profile->distributor = $this->distributor;
        $profile->save();

        $promotion = UserLifechangerPromotion::firstOrCreate([
            'user_id' => $this->user_id,
            'sspl_id' => '1',
        ]);
        $promotion->date_promoted = $this->sign_up_date;
        $promotion->save();

        $this->alert('success', 'Profile saved successfully!');
    }

    public function add_dependent()
    {
        $validate = $this->validate([
            'child_name' => ['required', 'string', 'max:255'],
            'child_dob' => ['required', 'date', 'before:' . date('Y-m-d')],
            'child_school' => ['nullable', 'string', 'max:255'],
        ], [
            'child_name.required' => 'Child name required...',
            'child_dob.required' => 'Child date of birth required...',
        ]);

        UserDependent::create([
            'user_id' => $this->user_id,
            'name' => $this->child_name,
            'birth_date' => $this->child_dob,
            'school' => $this->child_school,
        ]);
        $this->reset('child_name', 'child_dob', 'child_school');
        $this->alert('success', 'Added new dependent successfully!');
    }

    public function update_child($child_id)
    {
        $validate = $this->validate([
            'child_name' => ['required', 'string', 'max:255'],
            'child_dob' => ['required', 'date', 'before:' . date('Y-m-d')],
            'child_school' => ['nullable', 'string', 'max:255'],
        ], [
            'child_name.required' => 'Child name required...',
            'child_dob.required' => 'Child date of birth required...',
        ]);

        $child = UserDependent::find($child_id);
        $child->name = $this->child_name;
        $child->birth_date = $this->child_dob;
        $child->school = $this->child_school;
        $child->save();

        $this->reset('child_name', 'child_dob', 'child_school');
        $this->alert('success', 'Added new dependent successfully!');
    }

    public function remove_child($child_id)
    {
        $child = UserDependent::find($child_id);
        $child->delete();
        $this->alert('warning', 'Dependent removed!');
    }

    public function add_experience()
    {
        $validate = $this->validate([
            'exp_name' => ['required', 'string', 'max:255'],
            'exp_contact' => ['required', 'string', 'max:13'],
            'exp_position' => ['required', 'string', 'max:255'],
            'exp_salary' => ['required', 'integer'],
            'exp_from' => ['required', 'date', 'before:' . date('Y-m-d')],
            'exp_to' => ['nullable', 'date'],
        ], [
            'exp_name.required' => 'Company name is required...',
            'exp_contact.required' => 'Company contact is required...',
            'exp_position.required' => 'Position is required...',
            'exp_salary.required' => 'Salary is required...',
            'exp_salary.integer' => 'Salary must be a decimal...',
            'exp_from.required' => 'Date of start required...',
        ]);

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

    public function update_experience($work_id)
    {
        $validate = $this->validate([
            'exp_name' => ['required', 'string', 'max:255'],
            'exp_contact' => ['required', 'string', 'max:13'],
            'exp_position' => ['required', 'string', 'max:255'],
            'exp_salary' => ['required', 'integer'],
            'exp_from' => ['required', 'date', 'before:' . date('Y-m-d')],
            'exp_to' => ['nullable', 'date'],
        ], [
            'exp_name.required' => 'Company name is required...',
            'exp_contact.required' => 'Company contact is required...',
            'exp_position.required' => 'Position is required...',
            'exp_salary.required' => 'Salary is required...',
            'exp_salary.integer' => 'Salary must be a decimal...',
            'exp_from.required' => 'Date of start required...',
        ]);

        $work = UserWorkExperience::find($work_id);
        $work->name = $this->exp_name;
        $work->contact = $this->exp_contact;
        $work->position = $this->exp_position;
        $work->salary = $this->exp_salary;
        $work->from_date = $this->exp_from;
        $work->to_date = $this->exp_to;
        $work->save();

        $this->reset('exp_name', 'exp_contact', 'exp_position', 'exp_salary', 'exp_from', 'exp_to');
        $this->alert('success', 'Updated dependent successfully!');
    }

    public function remove_experience($work_id)
    {
        $child = UserWorkExperience::find($work_id);
        $child->delete();
        $this->alert('warning', 'Work experience removed!');
    }

    public function add_reference()
    {
        $validate = $this->validate([
            'ref_name' => ['required', 'string', 'max:255'],
            'ref_rel' => ['required', 'string', 'max:255'],
            'ref_contact' => ['required', 'string', 'max:13'],
        ], [
            'ref_name.required' => 'Reference name is required...',
            'ref_contact.required' => 'Reference contact is required...',
            'ref_rel.required' => 'Relationship to reference is required...',
        ]);

        UserCharacterReference::create([
            'user_id' => $this->user_id,
            'name' => $this->ref_name,
            'relationship' => $this->ref_rel,
            'contact' => $this->ref_contact,
        ]);
        $this->reset('ref_name', 'ref_rel', 'ref_contact');
        $this->alert('success', 'Added new character reference successfully!');
    }

    public function update_reference($ref_id)
    {
        $validate = $this->validate([
            'ref_name' => ['required', 'string', 'max:255'],
            'ref_rel' => ['required', 'string', 'max:255'],
            'ref_contact' => ['required', 'string', 'max:13'],
        ], [
            'ref_name.required' => 'Reference name is required...',
            'ref_contact.required' => 'Reference contact is required...',
            'ref_rel.required' => 'Relationship to reference is required...',
        ]);

        $ref = UserCharacterReference::find($ref_id);
        $ref->user_id = $this->user_id;
        $ref->name = $this->ref_name;
        $ref->relationship = $this->ref_rel;
        $ref->contact = $this->ref_contact;
        $ref->save();

        $this->reset('ref_name', 'ref_rel', 'ref_contact');
        $this->alert('success', 'Updated reference successfully!');
    }

    public function remove_reference($ref_id)
    {
        $ref = UserCharacterReference::find($ref_id);
        $ref->delete();
        $this->alert('warning', 'Character reference removed!');
    }

    public function add_promotion()
    {
        $validate = $this->validate([
            'sspl_id' => ['required', 'string', 'max:1'],
            'date_promoted' => ['required', 'date', 'beforeOrEqual:' . date('Y-m-d')],
        ], [
            'ref_name.required' => 'Reference name is required...',
        ]);

        $promotion = UserLifechangerPromotion::firstOrCreate([
            'user_id' => $this->user_id,
            'sspl_id' => $this->sspl_id,
        ]);
        $promotion->date_promoted = $this->date_promoted;
        $promotion->save();

        $this->reset('sspl_id', 'date_promoted');
        $this->alert('success', 'Added new promotion history successfully!');
    }

    public function delete_history($history_id)
    {
        $history = UserLifechangerPromotion::find($history_id);
        $history->delete();
        $this->alert('warning', 'Promotion history removed!');
    }
}
