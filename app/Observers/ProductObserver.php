<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductLog;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    protected function getChangedBy(): ?int
    {
        return Auth::check() ? Auth::id() : null;
    }

    public function created(Product $product): void
    {
        ProductLog::create([
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'action'       => 'created',
            'changed_by'   => $this->getChangedBy(),
            'changes'      => [
                'new' => $product->getAttributes(),
                'triggered_by' => Auth::check() ? 'admin' : 'guest',
            ],
        ]);
    }

    public function updated(Product $product): void
    {
        ProductLog::create([
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'action'       => 'updated',
            'changed_by'   => $this->getChangedBy(),
            'changes'      => [
                'old' => $product->getOriginal(),
                'new' => $product->getChanges(),
                'triggered_by' => Auth::check() ? 'admin' : 'guest',
            ],
        ]);
    }

    public function deleted(Product $product): void
    {
        ProductLog::create([
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'action'       => 'deleted',
            'changed_by'   => $this->getChangedBy(),
            'changes'      => [
                'triggered_by' => Auth::check() ? 'admin' : 'guest',
            ],
        ]);
    }
}
