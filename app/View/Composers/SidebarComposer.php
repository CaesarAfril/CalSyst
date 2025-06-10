<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Department;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SidebarComposer
{
    public function compose(View $view): void
    {
        $plantDropdown = request()->input('plant'); // ✅ fetch request data here
        $departments = Department::fetchdataSidebar($plantDropdown);
        $plant = Plant::all();

        $view->with([
            'departments' => $departments,
            'plants' => $plant
        ]);
    }
}
