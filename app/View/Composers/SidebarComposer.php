<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Department;
use Illuminate\Support\Facades\Cache;

class SidebarComposer
{
    public function compose(View $view): void
    {
        $departments = Cache::remember('sidebar_departments', 3600, function () {
            return Department::whereNull('deleted_at')->get();
        });

        $view->with('departments', $departments);
    }
}
