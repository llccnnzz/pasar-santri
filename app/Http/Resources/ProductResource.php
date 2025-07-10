<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'slug' => $this['slug'],
            'name' => $this['name'],
            'shop_name' => $this->whenLoaded('shop') ? $this->shop->name : 'unknown',
            'shop_slug' => $this->whenLoaded('shop') ? $this->shop->slug : '#',
            'meta_description' => $this['meta_description'],
            'long_description' => $this['long_description'],
            'price' => $this['price'],
            'final_price' => $this['final_price'],
            'tags' => $this['tags'],
            'specification' => $this['specification'],
            'final_stock' => $this['final_stock'],
            'stock' => $this['stock'],
            'has_variant' => $this['has_variant'],
            'default_image' => MediaResource::make($this->whenLoaded('defaultImage')),
            'hover_image' => MediaResource::make($this->whenLoaded('hoverImage')),
        ];
    }
}
