<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait Searchable
{
    public function search(string $term): Builder
    {
        return $this->builder->search($term);
    }
}
