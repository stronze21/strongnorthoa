<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;

class Masterlist extends Component
{

    public function render()
    {
        $users = User::paginate(15);
        return view('livewire.profile.masterlist', [
            'users' => $users,
        ]);
    }
}
