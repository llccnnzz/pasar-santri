@extends('layouts.seller.main')

@section('title', 'Products - Seller Dashboard')

@section('content')
<!--=== Start Section Title Area ===-->
<div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
    <h4 class="text-dark mb-0">Products</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="/seller/dashboard">Seller Dashboard</a></li>
{{--            <li class="breadcrumb-item fs-14">Pages</li>--}}
            <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Products</li>
        </ol>
    </nav>
</div>
<!--=== End Section Title Area ===-->

<!--=== Start Products Area ===-->
<div class="card rounded-3 border-0 products-card mb-24 table-edit-area">
    <div class="card-body text-body p-25">
        <div class="card-title d-sm-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color">
            <h4 class="mb-2 mb-sm-0">Products</h4>

            <div class="d-sm-flex align-items-center">
                <form action="{{ route('seller.products.index') }}" method="GET" class="src-form position-relative z-1 me-sm-3 mb-2 mb-sm-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control h-40" placeholder="Search Here">
                    <button class="bg-transparent position-absolute position-absolute top-50 end-0 translate-middle border-0 ps-0 pe-1">
                        <i data-feather="search" style="width: 20px;" class="text-body"></i>
                    </button>
                </form>
                <a href="{{ route('seller.products.create') }}" class="btn btn-primary w-sm-100">
                    <i data-feather="plus"></i>
                    Create New
                </a>
            </div>
        </div>

        <div class="table-wrapper">
            <div class="member">
                <div class="delete">
                    <div class="overplay"></div>
                    <div class="choice-delete">
                        <i class="fas fa-times"></i>
                        <h1>Do you delete?</h1>
                        <button type="button" name="cancel-delete" class="btn">Cancel</button>
                        <button type="button" name="yes-delete" class="btn">Delete</button>
                    </div>
                </div>

                <div class="global-table-area">
                    <div class="table-responsive overflow-auto">
                        <table class="table align-middle table-bordered" >
                            <thead class="text-dark">
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Product Colors</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-body o-sortable">
                                @forelse ($products as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" style="position: relative; top: -2px;">
                                            </div>
                                            <a href="/seller/products/{{ $product->slug }}" class="d-flex align-items-center text-decoration-none">
                                                <img class="rounded-3 wh-50" src="{{ $product->defaultImage->getFullUrl() }}" alt="product-1">
                                                <span class="fw-medium fs-15 ms-3 edit">{{ $product->name }}</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="edit">
                                        @if($product->stock <= 0)
                                            <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1 edit">Out of Stock</span>
                                        @elseif($product->stock <= 5)
                                            <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1 edit">Low Stock : </span>{{ $product->stock }}
                                        @else
                                            {{ $product->stock }}
                                        @endif
                                    </td>
                                    <td class="edit">{{ $product->categories->first()->name ?? 'N/A' }}</td>
                                    <td class="edit">
                                        Rp. {{ number_format($product->final_price) }}<br>
                                        <s>Rp. {{ number_format($product->price) }}</s>
                                    </td>
                                    <td>
                                        <ul class="ps-0 mb-0 list-unstyled d-flex justify-content-between">
                                            <li style="width: 15px; height: 15px;" class="bg-danger rounded-1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pink"></li>
                                            <li style="width: 15px; height: 15px;" class="bg-success rounded-1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Green"></li>
                                            <li style="width: 15px; height: 15px;" class="bg-warning rounded-1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Yellow"></li>
                                            <li style="width: 15px; height: 15px;" class="bg-info rounded-1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Sky Blue"></li>
                                        </ul>
                                    </td>
                                    <td class="edit">{{ $product->sku }}</td>
                                    <td>
                                        <div class="d-inline-block align-items-center badge bg-light fw-medium fs-12">
                                            <i data-feather="star" style="width: 14px; position: relative; top: -1px;" class="text-warning me-1"></i>
                                            <span class="text-body me-1">5.0</span>
                                            <span class="text-body">(4k)</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="/seller/products/{{ $product->slug }}" class="icon icon-a border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </a>
                                        <button onclick="window.location.href='/seller/products/{{ $product->slug }}/edit'" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button name="delete" class="icon border-0 rounded-circle text-center trash bg-danger-transparent delete-item">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="bx bx-category-alt" style="font-size: 48px; color: #ccc;"></i>
                                                <h6 class="mt-2 text-muted">No products found</h6>
                                                <p class="text-muted">
                                                    @if(request('search'))
                                                        No products match your search criteria.
                                                    @else
                                                        Start by creating your first product.
                                                    @endif
                                                </p>
                                                @if(!request('search'))
                                                    <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus me-1"></i>Create Product
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mt-25 text-center">
                        <span class="fs-15 fw-medium text-dark mb-10 mb-sm-0 d-block">Items Per Page Show 10</span>
                        {{ $products->withQueryString()->links('layouts.seller.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Products Area ===-->
@endsection
