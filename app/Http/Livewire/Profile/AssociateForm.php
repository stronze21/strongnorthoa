<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use App\Models\UserCharacterReference;
use App\Models\UserDependent;
use App\Models\UserLifechangerPromotion;
use App\Models\UserWorkExperience;
use Carbon\Carbon;
use Livewire\Component;

class AssociateForm extends Component
{

    public $user_id;

    public function render()
    {
        $user = User::find($this->user_id);

        $dependents = UserDependent::where('user_id', $this->user_id)->get();
        $works = UserWorkExperience::where('user_id', $this->user_id)->get();
        $references = UserCharacterReference::where('user_id', $this->user_id)->get();
        $promotions = UserLifechangerPromotion::where('user_id', $this->user_id)->whereRelation('sspl', 'type', 'lifechanger')->orderBy('date_promoted', 'DESC')->get();
        if(count($promotions) < 1){
            $sspl = UserLifechangerPromotion::where('user_id', $this->user_id)->whereRelation('sspl', 'type', 'partner')->orderBy('date_promoted', 'DESC')->first();
            $type = $sspl->sspl->level . ' Partner';
        }else{
            $type = $promotions[0]->sspl->level;
        }
        return view('livewire.profile.associate-form', compact('user', 'dependents', 'works', 'references', 'promotions', 'type'));
    }

    public function mount($userID)
    {
        $this->user_id = $userID;
    }
}