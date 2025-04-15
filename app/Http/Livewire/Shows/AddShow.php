<?php

namespace App\Http\Livewire\Shows;

use App\Models\CookingShow;
use App\Models\Sspl;
use App\Models\User;
use App\Models\Province;
use App\Models\Municipality;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddShow extends Component
{
    use LivewireAlert;

    protected $listeners = ['reroute'];

    // Step management
    public $currentStep = 1;
    public $totalSteps = 3;

    // Form fields
    public $date, $time, $type;
    public $host, $host_surename, $host_middlename, $spouse, $address, $address_2, $city_town, $province, $contact_no, $occupation, $host_email, $social_media;
    public $lifechanger, $presenter, $partner_id, $partner_type, $team_builder, $distributor, $sspl;
    public $reason1, $reason2;
    public $min_date;
    public $partners = [];
    public $lifechangers = []; // Added for presenter dropdown selection

    // Location data
    public $provinces = [];
    public $municipalities = [];
    public $province_id = null;
    public $municipality_id = null;

    // Define rules for all steps - this is required by Livewire
    protected $rules = [
        'date' => 'required|date|date_format:Y-m-d',
        'time' => 'required',
        'type' => 'required|string',
        'host' => 'required|string',
        'host_middlename' => 'nullable|string',
        'host_surename' => 'required|string',
        'spouse' => 'nullable|string',
        'address' => 'required|string',
        'address_2' => 'nullable|string',
        'province_id' => 'required',
        'municipality_id' => 'required',
        'contact_no' => 'required|string|unique:cooking_shows,contact_no',
        'occupation' => 'nullable|string',
        'host_email' => 'required|email',
        'social_media' => 'nullable|string',
        'lifechanger' => 'required|string',
        'presenter' => 'required|string',
        'partner_id' => 'nullable|string',
        'partner_type' => 'nullable|string',
        'team_builder' => 'required|string',
        'distributor' => 'required|string',
        'sspl' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.shows.add-show', [
            'provinces' => $this->provinces,
            'municipalities' => $this->municipalities,
            'lifechangers' => $this->lifechangers,
        ]);
    }

    public function mount()
    {
        $this->min_date = date('Y-m-d');
        $this->date = $this->min_date;
        $this->time = date('H:i');
        $this->type = 'Face to Face';
        $this->host = null;
        $this->spouse = null;
        $this->address = null;
        $this->contact_no = null;
        $this->occupation = null;
        $this->host_email = null;
        $this->social_media = null;
        $this->lifechanger = Auth::user()->fullname();
        $this->presenter = Auth::user()->fullname(); // Set the presenter to current user's full name
        $this->partner_id = null;
        $this->partner_type = null;
        $this->team_builder = Auth::user()->profile->builder ? Auth::user()->profile->builder->fullname() : 'N/A';
        $this->distributor = Auth::user()->profile->distrib ? Auth::user()->profile->distrib->fullname() : 'N/A';
        $this->sspl = Auth::user()->cur_level ? Auth::user()->cur_level->sspl->level : '0';

        // Load partners
        $this->partners = User::whereHas('cur_level', function ($query) {
            $query->whereHas('sspl', function ($query) {
                $query->where('type', 'partner');
            });
        })->get();

        // Load lifechangers for presenter selection
        $this->lifechangers = User::role('user')
            ->select('user_id', 'f_name', 'l_name', 'm_name', 'full_name')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->user_id,
                    'name' => $user->fullname()
                ];
            })
            ->pluck('name', 'name')
            ->toArray();

        // Load provinces
        $this->provinces = Province::orderBy('province_name')->get();

        $this->reason1 = null;
        $this->reason2 = null;
    }

    // When province changes, update municipalities
    public function updatedProvinceId($value)
    {
        $this->municipality_id = null; // Reset municipality selection
        $this->loadMunicipalities($value);
    }

    // Load municipalities based on selected province
    public function loadMunicipalities($provinceId)
    {
        if ($provinceId) {
            $this->municipalities = Municipality::where('province_id', $provinceId)
                ->orderBy('municipality_name')
                ->get();
        } else {
            $this->municipalities = [];
        }
    }

    // Step Navigation Methods
    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    // Get rules for current step only
    protected function getStepRules()
    {
        $stepRules = [
            1 => [
                'date' => 'required|date|date_format:Y-m-d|after_or_equal:' . $this->min_date,
                'time' => 'required',
                'type' => 'required|string',
                'host' => 'required|string',
                'host_surename' => 'required|string',
                'host_middlename' => 'nullable|string',
                'spouse' => 'nullable|string',
            ],
            2 => [
                'address' => 'required|string',
                'address_2' => 'nullable|string',
                'province_id' => 'required',
                'municipality_id' => 'required',
                'contact_no' => 'required|string|unique:cooking_shows,contact_no',
                'occupation' => 'nullable|string',
            ],
            3 => [
                'host_email' => 'required|email',
                'social_media' => 'nullable|string',
                'lifechanger' => 'required|string',
                'presenter' => 'required|string',
                'partner_id' => 'nullable|string',
                'partner_type' => 'nullable|string',
                'team_builder' => 'required|string',
                'distributor' => 'required|string',
                'sspl' => 'required|string',
            ],
        ];

        return $stepRules[$this->currentStep] ?? [];
    }

    // Validate current step
    public function validateCurrentStep()
    {
        $stepRules = $this->getStepRules();
        $this->validate($stepRules);
    }

    public function updated($propertyName)
    {
        // Validate field as it's updated
        $stepRules = $this->getStepRules();
        if (array_key_exists($propertyName, $stepRules)) {
            $this->validateOnly($propertyName, [$propertyName => $stepRules[$propertyName]]);
        }
    }

    public function save()
    {
        // Validate the final step
        $this->validateCurrentStep();

        // Final validation of all fields using the main rules
        $this->validate();

        if ($this->partner_id) {
            $this->partner_type = User::find($this->partner_id)->cur_level->sspl->level;
        }

        // Get province and municipality names from IDs
        $provinceName = Province::find($this->province_id)->province_name ?? '';
        $municipalityName = Municipality::find($this->municipality_id)->municipality_name ?? '';

        $new_show = new CookingShow;
        $new_show->date = $this->date;
        $new_show->time = $this->time;
        $new_show->type = $this->type;
        $new_show->host = $this->host;
        $new_show->host_middlename = $this->host_middlename;
        $new_show->host_surename = $this->host_surename;
        $new_show->spouse = $this->spouse;
        $new_show->address = $this->address;
        $new_show->address_2 = $this->address_2;
        $new_show->city_town = $municipalityName;
        $new_show->province = $provinceName;
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
        $this->redirect(route('my-cooking-shows'));
    }
}
