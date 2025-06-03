<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait HasAreaScope
{
    public function scopeHasArea(Builder $query): Builder
    {
        $user = User::with(['plant', 'department'])->find(Auth::id());
        $superadmin = $user->isSuperAdmin();
        $admin = $user->isAdmin();
        $calibrator = $user->isCalibrator();
        $plant = $user->plant->uuid;
        $department = $user->department->uuid;

        if ($superadmin || $calibrator) {
            return $query;
        } elseif ($admin) {
            return $query->where($query->getModel()->getTable() . '.plant_uuid', $plant);
        } else {
            return $query->where($query->getModel()->getTable() . '.plant_uuid', $plant)->where($query->getModel()->getTable() . '.dept_uuid', $department);
        }
    }
}
