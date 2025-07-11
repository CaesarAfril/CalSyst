<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

trait HasAreaScope
{
    public function scopeHasArea(Builder $query, $relation = null): Builder
    {
        $user = User::with(['plant', 'department'])->find(Auth::id());

        if (!$user) {
            return $query;
        }

        $superadmin = $user->isSuperAdmin();
        $admin = $user->isAdmin();
        $calibrator = $user->isCalibrator();

        $plant = $user->plant->uuid ?? null;
        $department = $user->department->uuid ?? null;
        $departmentName = $user->department->department ?? null;

        $table = $query->getModel()->getTable();
        $hasDeptUuid = Schema::hasColumn($table, 'dept_uuid');

        // 🟢 Super Admin and Calibrator see everything
        if ($superadmin || $calibrator) {
            return $query;
        }

        // 🟡 Admins see all in their plant
        if ($admin || $departmentName === 'Engineering') {
            if ($relation) {
                return $query->whereHas($relation, function (Builder $q) use ($plant) {
                    $q->where('plant_uuid', $plant);
                });
            }

            return $query->where($table . '.plant_uuid', $plant);
        }

        // 🔴 Regular users – filter by department + plant
        if ($relation) {
            return $query->whereHas($relation, function (Builder $q) use ($plant, $department) {
                $q->where('plant_uuid', $plant)
                    ->where('dept_uuid', $department);
            });
        }

        return $query
            ->where($table . '.plant_uuid', $plant)
            ->when($hasDeptUuid, function ($q) use ($table, $department) {
                $q->where($table . '.dept_uuid', $department);
            });
    }
}
