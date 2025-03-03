<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DashboardComponent extends Component
{
    public function render()
    {
        // Determine which dashboard to show based on user role
        if (Auth::user()->hasRole('admin')) {
            return app(AdminDashboard::class)->render();
        } else {
            return app(UserDashboard::class)->render();
        }
    }
}