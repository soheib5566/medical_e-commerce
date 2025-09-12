<?php

namespace App\Filters\Website;

use App\Filters\QueryFilter;
use App\Traits\Searchable;

class ProductFilter extends QueryFilter
{
    use Searchable;
    public function minprice($value)
    {
        return $this->builder->minPrice($value);
    }

    public function maxprice($value)
    {
        return $this->builder->maxPrice($value);
    }
}
