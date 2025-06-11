<?php

// app/Traits/FilterByPlant.php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByPlant
{
    /**
     * Universal plant filter that works on model or relation
     *
     * @param Builder $query
     * @param string|null $plantUuid
     * @param string|null $relation (optional relationship name if filtering via relation)
     * @return Builder
     */
    public function scopeFilterByPlant($query, ?string $plantUuid, ?string $relation = null)
    {
        if (!$plantUuid) {
            return $query;
        }

        if ($relation) {
            return $query->whereHas($relation, function ($q) use ($plantUuid) {
                $q->where('plant_uuid', $plantUuid);
            });
        }

        return $query->where('plant_uuid', $plantUuid);
    }
}
