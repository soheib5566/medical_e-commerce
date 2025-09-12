<?php

namespace App\Models;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\ProductLog;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory, Filterable;

    protected $fillable = ['name', 'description', 'price', 'stock', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function logs()
    {
        return $this->hasMany(ProductLog::class);
    }

    public function scopeSearch($query, string $term)
    {
        if ($term) {
            $query->where('name', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        }

        return $query;
    }
}
