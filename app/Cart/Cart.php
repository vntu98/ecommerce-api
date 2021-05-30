<?php

namespace App\Cart;

use App\Models\ShippingMethod;
use App\Models\User;

class Cart
{
    protected $user;
    protected $changed = false;
    protected $shipping = false;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function withShipping($shippingId)
    {
        $this->shipping = ShippingMethod::find($shippingId);

        return $this;
    }

    public function add($products)
    {
        $this->user->cart()->syncWithoutDetaching($this->getStorePayload($products));
    }

    public function update($productId, $quantity)
    {
        $this->user->cart()->updateExistingPivot($productId, [
            'quantity' => $quantity
        ]);
    }

    public function delete($productId)
    {
        $this->user->cart()->detach($productId);
    }

    public function sync()
    {
        $this->user->cart->each(function ($product) {
            $quantity = $product->minStock($product->pivot->quantity);
            $this->changed = $quantity !== $product->pivot->quantity;
            
            $product->pivot->update([
                'quantity' => $quantity
            ]);
        });
    }

    public function products()
    {
        return $this->user->cart;
    }

    public function hasChanged()
    {
        return $this->changed;
    }

    public function empty()
    {
        $this->user->cart()->detach();
    }

    public function isEmpty()
    {
        return $this->user->cart->sum('pivot.quantity') <= 0;
    }

    public function subtotal()
    {
        $subtotal = $this->user->cart->sum(function ($product) {
            return $product->price->amount() * $product->pivot->quantity;
        });

        return new Money($subtotal);
    }

    public function total()
    {
        if ($this->shipping) {
            return $this->subtotal()->add($this->shipping->price);
        }

        return $this->subtotal();
    }

    public function getStorePayload($products)
    {
        return collect($products)->keyBy('id')->map(function ($item) {
            return [
                'quantity' => $item['quantity'] + $this->getCurrentQuantity($item['id'])
            ];
        })->toArray();
    }

    public function getCurrentQuantity($productVariationId)
    {
        if ($product = $this->user->cart->where('id', $productVariationId)->first()) {
            return $product->pivot->quantity;
        }

        return 0;
    }
}

