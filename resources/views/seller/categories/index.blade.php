@extends('layouts.seller.main')

@section('title', 'Category Management')

@section('content')
<!--=== Start Section Title Area ===-->
<div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
    <h4 class="text-dark mb-0">Category</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="/seller/dashboard">Seller Dashboard</a></li>
{{--            <li class="breadcrumb-item fs-14">Pages</li>--}}
            <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Category</li>
        </ol>
    </nav>
</div>
<!--=== End Section Title Area ===-->

<!--=== Start Category Area ===-->
<div class="card rounded-3 border-0 products-card mb-24 table-edit-area">
    <div class="card-body text-body p-25">
        <div class="card-title d-sm-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color">
            <h4 class="mb-2 mb-sm-0">Category</h4>

            <div class="d-sm-flex align-items-center">
                <form method="GET" action="{{ route('seller.categories.index') }}" class="src-form position-relative z-1 me-sm-3 mb-2 mb-sm-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control h-40" placeholder="Search Here">
                    <button class="bg-transparent position-absolute position-absolute top-50 end-0 translate-middle border-0 ps-0 pe-1">
                        <i data-feather="search" style="width: 20px;" class="text-body"></i>
                    </button>
                </form>
                <a href="{{ route('seller.categories.create') }}" class="btn btn-primary w-sm-100">
                    <i data-feather="plus"></i>
                    Create New
                </a>
            </div>
        </div>

        <div class="table-wrapper">
            <div class="member">
                <div class="global-table-area">
                    <div class="table-responsive overflow-auto">
                        <table class="table align-middle table-bordered" >
                            <thead class="text-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Products Count</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="text-body o-sortable">
                            @forelse ($categories as $category)
                                <tr>
                                    <td>
                                        <strong>{{ $category->name }}</strong>
                                    </td>
                                    <td>
                                        <code>{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                         <span class="badge bg-info">
                                            {{ $category->products()->where('shop_id', auth()->user()->shop->id)->count() }} products
                                        </span>
                                    </td>
                                    <td>{{ $category->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <button onclick="window.location.href='{{ route('seller.categories.edit', $category->id) }}'" class="icon border-0 rounded-circle text-center edit bg-success-transparent edit-item">
                                            <i data-feather="edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="bx bx-category-alt" style="font-size: 48px; color: #ccc;"></i>
                                            <h6 class="mt-2 text-muted">No categories found</h6>
                                            <p class="text-muted">
                                                @if(request('search'))
                                                    No categories match your search criteria.
                                                @else
                                                    Start by creating your first category.
                                                @endif
                                            </p>
                                            @if(!request('search'))
                                                <a href="{{ route('seller.categories.create') }}" class="btn btn-primary">
                                                    <i class="bx bx-plus me-1"></i>Create Category
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
                        {{ $categories->withQueryString()->links('layouts.seller.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Category Area ===-->
@endsection
