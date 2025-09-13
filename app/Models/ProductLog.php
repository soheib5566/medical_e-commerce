<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    /** @use HasFactory<\Database\Factories\ProductLogFactory> */
    use HasFactory;

    protected $fillable = ['product_id', 'product_name', 'action', 'changed_by', 'changes'];

    protected $casts = [
        'changes' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
