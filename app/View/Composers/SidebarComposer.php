<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Department;
use Illuminate\Support\Facades\Cache;

class SidebarComposer
{
    public function compose(View $view): void
    {
        $departments = Department::with('validation_assets')
            ->whereHas('validation_assets')
            ->whereNull('deleted_at')
            ->get();

        $view->with('departments', $departments);
    }
}
