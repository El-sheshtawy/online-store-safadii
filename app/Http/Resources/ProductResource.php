<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Product Number' => $this->id,
            'Product Name' => $this->name,
            'Description Product' => $this->description,
            'Product Price after discount' => $this->price,
            'Price before discount' => $this->compact_price ?? 'This product not have discount',
            'Product image' => $this->image_url,
            'Product Relations' => [
               'Product Category' => [
                   'Category number' => $this->category->id,
                   'Category Name' => $this->category->name,
               ],
               'Product Store' => [
                   'Store id' => $this->store->id,
                   'Store Name' => $this->store->name,
               ],
            ]
        ];
    }
}
