<?php

namespace App\Traits;

use App\Filters\QueryFilter;

trait Filterable
{
    public function scopeFilters($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
