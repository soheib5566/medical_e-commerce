<?php

namespace App\Filters\Admin;

use App\Filters\QueryFilter;
use App\Traits\Searchable;

class ProductFilter extends QueryFilter
{
    use Searchable;
}
