<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Masterlist extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $f_name, $m_name, $l_name, $email, $search;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::where('full_name', 'LIKE', '%' . $this->search . '%')->paginate(15);
        return view('livewire.profile.masterlist', [
            'users' => $users,
        ]);
    }

    public function view_lc($user_id)
    {
        return $this->redirect(route('lc.profile', $user_id));
    }

    public function save_user()
    {
        $this->validate([
            'f_name' => ['required', 'string', 'max:255'],
            'm_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        User::create([
            'full_name' => $this->l_name . ', ' . $this->f_name . ' ' . $this->m_name,
            'l_name' => $this->l_name,
            'f_name' => $this->f_name,
            'm_name' => $this->m_name,
            'email' => $this->email,
            'pw' => Hash::make('strongnorth'),
        ]);
        $this->reset();
        $this->alert('success', 'New user created!');
    }
}
