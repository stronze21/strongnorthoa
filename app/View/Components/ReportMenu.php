<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class ReportMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $reportTypes = config('reports.types');

        // Filter report types based on user permissions
        $user = Auth::user();
        $allowedReports = [];

        foreach ($reportTypes as $key => $report) {
            if ($this->userCanAccessReport($user, $key)) {
                $allowedReports[$key] = $report;
            }
        }

        return view('components.report-menu', [
            'reports' => $allowedReports,
        ]);
    }

    /**
     * Check if the user can access a specific report type
     *
     * @param \App\Models\User $user
     * @param string $reportType
     * @return bool
     */
    protected function userCanAccessReport($user, $reportType)
    {
        // Get allowed roles for this report type
        $allowedRoles = config('reports.permissions.' . $reportType, []);

        // Check if user has any of the allowed roles
        foreach ($allowedRoles as $role) {
            if ($user->hasRole($role)) {
                return true;
            }
        }

        return false;
    }
}
