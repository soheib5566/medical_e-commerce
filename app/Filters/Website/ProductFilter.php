<?php

namespace App\Filters\Website;

use App\Filters\QueryFilter;

class ProductFilter extends QueryFilter
{
    public function search($value)
    {
        if (empty($value)) {
            return $this->builder;
        }
        
        return $this->builder->where(function($query) use ($value) {
            $query->where('name', 'like', "%{$value}%")
                  ->orWhere('description', 'like', "%{$value}%");
        });
    }

    public function category($value = null)
    {
        if (empty($value)) {
            return $this->builder;
        }
        
        return $this->builder->where('category_id', $value);
    }

    public function min_price($value = 0)
    {
        if (empty($value)) {
            return $this->builder;
        }
        
        return $this->builder->where('price', '>=', $value);
    }

    public function max_price($value = 0)
    {
        if (empty($value)) {
            return $this->builder;
        }
        
        return $this->builder->where('price', '<=', $value);
    }

    public function sort($value)
    {
        switch ($value) {
            case 'price_asc':
                return $this->builder->orderBy('price', 'asc');
            case 'price_desc':
                return $this->builder->orderBy('price', 'desc');
            case 'newest':
                return $this->builder->orderBy('created_at', 'desc');
            case 'name':
            default:
                return $this->builder->orderBy('name', 'asc');
        }
    }
}
