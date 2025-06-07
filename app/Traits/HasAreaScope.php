<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait HasAreaScope
{
    public function scopeHasArea(Builder $query, $relation = NULL): Builder
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
            if ($relation) {
                return $query->whereHas($relation, function (Builder $q) use ($plant) {
                    $q->where('plant_uuid', $plant);
                });
            }

            return $query->where($query->getModel()->getTable() . '.plant_uuid', $plant);
        } else {
            if ($relation) {
                return $query->where($query->getModel()->getTable() . '.dept_uuid', $department)->whereHas($relation, function (Builder $q) use ($plant) {
                    $q->where('plant_uuid', $plant);
                });
            }
            return $query->where($query->getModel()->getTable() . '.plant_uuid', $plant)->where($query->getModel()->getTable() . '.dept_uuid', $department);
        }
    }
}
