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
        $query = QueryBuilder::for(Product::class)
            ->select([
                'id', 'slug', 'name', 'shop_id', 'meta_description', 'long_description',
                'price', 'final_price', 'tags', 'stock', 'has_variant', 'created_at'
            ])
            ->allowedFilters([
                AllowedFilter::callback('categories', function (Builder $query, $value) {
                    $query->whereHas('categories', function (Builder $query) use ($value) {
                        $query->whereIn('categories.id', $value);
                    });
                }),
                AllowedFilter::callback('category_slug', function (Builder $query, $value) {
                    $query->whereHas('categories', function (Builder $query) use ($value) {
                        $query->where('categories.slug', $value);
                    });
                }),
                AllowedFilter::callback('brands', function (Builder $query, $value) {
                   $query->whereIn('shop_id', $value);
                }),
                AllowedFilter::callback('tags', function (Builder $query, $value) {
                    $query->where(function ($q) use ($value) {
                        foreach ($value as $tag) {
                            $q->orWhereJsonContains('tags', $tag);
                        }
                    });
                }),
                AllowedFilter::callback('price_range', function (Builder $query, $value) {
                    if (isset($value['min'])) {
                        $query->where('final_price', '>=', $value['min']);
                    }
                    if (isset($value['max'])) {
                        $query->where('final_price', '<=', $value['max']);
                    }
                }),
                AllowedFilter::callback('search', function (Builder $query, $value) {
                    $searchTerms = explode(' ', $value);
                    $query->where(function ($q) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $q->where(function ($subQuery) use ($term) {
                                $subQuery->where('name', 'LIKE', "%{$term}%")
                                    ->orWhere('meta_description', 'LIKE', "%{$term}%")
                                    ->orWhereJsonContains('tags', $term)
                                    ->orWhereHas('shop', function ($shopQuery) use ($term) {
                                        $shopQuery->where('name', 'LIKE', "%{$term}%");
                                    })
                                    ->orWhereHas('categories', function ($catQuery) use ($term) {
                                        $catQuery->where('name', 'LIKE', "%{$term}%");
                                    });
                            });
                        }
                    });
                }),
            ])
            ->with(['defaultImage', 'hoverImage', 'shop:id,name,slug'])
            ->whereNotNull('final_price');

        // Handle sorting with stock priority
        $sortParam = $request->get('sort');
        if ($sortParam) {
            if (str_starts_with($sortParam, '-')) {
                $field = substr($sortParam, 1);
                $direction = 'DESC';
            } else {
                $field = $sortParam;
                $direction = 'ASC';
            }
            
            switch ($field) {
                case 'final_price':
                    $query->orderByRaw("CASE WHEN stock > 0 THEN 0 ELSE 1 END, final_price {$direction}");
                    break;
                case 'created_at':
                    $query->orderByRaw("CASE WHEN stock > 0 THEN 0 ELSE 1 END, created_at {$direction}");
                    break;
                case 'name':
                    $query->orderByRaw("CASE WHEN stock > 0 THEN 0 ELSE 1 END, name {$direction}");
                    break;
                default:
                    $query->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, created_at DESC');
            }
        } else {
            // Default sorting: in-stock first, then by created_at
            $query->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, created_at DESC');
        }

        $products = $query->jsonPaginate($request->get('page.size', 20));

        return ProductResource::collection($products);
    }
}
