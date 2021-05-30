<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class ProductVariationResources extends JsonResource
{
    public function toArray($request)
    {
        if ($this->resource instanceof Collection) {
            return ProductVariationResources::collection($this->resource);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->formatted_price,
            'price_varies' => $this->priceVaries(),
            'stock_count' => $this->stockCount(),
            'in_stock' => $this->inStock(),
            'product' => new ProductIndexResource($this->product)
        ];
    }
}
