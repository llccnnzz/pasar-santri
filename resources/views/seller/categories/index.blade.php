@extends('layouts.seller.main')

@section('title', 'Category Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 col-md-12 order-1">
            <div class="card">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-header">Category Management</h5>
                    <div class="card-header">
                        <a href="{{ route('seller.categories.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i>Add New Category
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="card-body">
                    <form method="GET" action="{{ route('seller.categories.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           class="form-control" 
                                           placeholder="Search categories by name or slug...">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(request('search'))
                                    <a href="{{ route('seller.categories.index') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-x"></i> Clear Search
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Categories Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Products Count</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
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
                                        <td>
                                            {{ $category->created_at->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('seller.categories.show', $category) }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('seller.categories.edit', $category) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('seller.categories.destroy', $category) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Are you sure you want to delete this category?')"
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
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

                    <!-- Pagination -->
                    @if($categories->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p class="text-muted small">
                                    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
                                </p>
                            </div>
                            <div>
                                {{ $categories->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush
