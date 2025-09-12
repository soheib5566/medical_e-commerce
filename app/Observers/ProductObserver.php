<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductLog;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        ProductLog::create([
            'product_id' => $product->id,
            'action'     => 'created',
            'changed_by' => Auth::id(),
            'changes'    => json_encode($product->getAttributes()), // initial values
        ]);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        ProductLog::create([
            'product_id' => $product->id,
            'action'     => 'updated',
            'changed_by' => Auth::id(),
            'changes'    => json_encode([
                'old' => $product->getOriginal(),
                'new' => $product->getChanges(),
            ]),
        ]);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        ProductLog::create([
            'product_id' => $product->id,
            'action'     => 'deleted',
            'changed_by' => Auth::id(),
            'changes'    => null,
        ]);
    }
}
