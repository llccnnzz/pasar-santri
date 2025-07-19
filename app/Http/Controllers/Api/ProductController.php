<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = QueryBuilder::for(Product::class)
            ->allowedFilters([
                AllowedFilter::callback('categories', function (Builder $query, $value) {
                    $query->whereHas('categories', function (Builder $query) use ($value) {
                        $query->whereIn('id', $value);
                    });
                }),
                AllowedFilter::callback('brands', function (Builder $query, $value) {
                   $query->whereIn('shop_id', $value);
                }),
                AllowedFilter::callback('tags', function (Builder $query, $value) {
                    $tags = $value;
                    $query->where(function ($q) use ($tags) {
                        foreach ($tags as $tag) {
                            $q->orWhereJsonContains('tags', $tag);
                        }
                    });
                }),
            ])
            ->allowedSorts(['final_price', 'created_at', 'name'])
            ->with(['defaultImage', 'hoverImage', 'shop'])
            ->jsonPaginate();

        return ProductResource::collection($products);
    }
}
