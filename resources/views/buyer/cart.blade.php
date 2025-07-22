@extends('layouts.landing.component.app')

@section('title') Shopping Cart @endsection
@section('description') Review and manage items in your shopping cart @endsection

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.out-of-stock {
    opacity: 0.6;
}
.out-of-stock .product-thumbnail img {
    filter: grayscale(1);
}
.quantity-controls {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    max-width: 120px;
}
.quantity-controls button {
    background: #f8f9fa;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 16px;
}
.quantity-controls button:hover {
    background: #e9ecef;
}
.quantity-controls input {
    border: none;
    text-align: center;
    width: 60px;
    padding: 8px 4px;
    background: white;
}
.price-changed {
    color: #dc3545;
    font-size: 12px;
}
</style>
@endpush

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shopping Cart
                </div>
            </div>
        </div>
        
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">Your Cart</h1>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are <span class="text-brand">{{ count($cartItems ?? []) }}</span> products in your cart</h6>
                        @if(!empty($cartItems))
                            <h6 class="text-body">
                                <a href="#" class="text-muted" onclick="clearCart()">
                                    <i class="fi-rs-trash mr-5"></i>Clear Cart
                                </a>
                            </h6>
                        @endif
                    </div>
                </div>
            </div>
            
            @if(session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('errors') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    @if(empty($cartItems))
                        <div class="text-center py-5">
                            <i class="fi-rs-shopping-cart display-1 text-muted"></i>
                            <h3 class="mt-3">Your cart is empty</h3>
                            <p class="text-muted">Looks like you haven't added any items to your cart yet.</p>
                            <a href="/products" class="btn btn-primary">Start Shopping</a>
                        </div>
                    @else
                        <div class="table-responsive shopping-summery">
                            <table class="table table-wishlist">
                                <thead>
                                    <tr class="main-heading">
                                        <th scope="col">&nbsp;</th>    
                                        <th scope="col">Product</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col" class="end">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $i => $item)
                                    <tr class="{{ $i === 0 ? 'pt-30' : '' }} {{ !$item['is_available'] ? 'out-of-stock' : '' }}" 
                                        data-product-id="{{ $item['id'] }}">
                                        <td class="image product-thumbnail pl-40">
                                            <img src="{{ $item['image'] ?? '/assets/imgs/shop/product-1-1.jpg' }}" alt="{{ $item['name'] }}" style="width: 80px; height: 80px; object-fit: cover;">
                                        </td>
                                        <td class="product-des product-name">
                                            <h6 class="mb-5">
                                                <a class="product-name mb-10 text-heading {{ $item['is_available'] ? '' : 'text-muted' }}" 
                                                   href="/{{ $item['slug'] }}">{{ $item['name'] }}</a>
                                            </h6>
                                            <div class="product-rate-cover">
                                                <span class="font-small text-muted">By {{ $item['shop_name'] ?? 'Unknown' }}</span>
                                            </div>
                                            @if(!$item['is_available'])
                                                <span class="badge bg-danger mt-2">{{ $item['message'] }}</span>
                                            @endif
                                            <!-- @if(isset($item['original_price']) && $item['original_price'] != $item['price'])
                                                <div class="price-changed">Price updated</div>
                                            @endif -->
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h4 class="text-brand">Rp. {{ number_format($item['price']) }}</h4>
                                            @if(isset($item['original_price']) && $item['original_price'] != $item['price'])
                                                <small class="text-muted"><s>Rp. {{ number_format($item['original_price']) }}</s></small>
                                            @endif
                                        </td>
                                        <td class="text-center detail-info" data-title="Quantity">
                                            @if($item['is_available'])
                                                <div class="quantity-controls">
                                                    <button type="button" onclick="updateQuantity('{{ $item['id'] }}', -1)">-</button>
                                                    <input type="number" 
                                                           value="{{ $item['quantity'] }}" 
                                                           min="1" 
                                                           max="{{ $item['stock'] ?? 999 }}"
                                                           onchange="updateQuantityInput('{{ $item['id'] }}', this.value)"
                                                           class="quantity-input">
                                                    <button type="button" onclick="updateQuantity('{{ $item['id'] }}', 1)">+</button>
                                                </div>
                                                @if(isset($item['available_quantity']) && $item['available_quantity'] < $item['quantity'])
                                                    <small class="text-warning">Only {{ $item['available_quantity'] }} available</small>
                                                @endif
                                            @else
                                                <span class="text-danger">{{ $item['message'] }}</span>
                                            @endif
                                        </td>
                                        <td class="price item-total" data-title="Subtotal">
                                            <h4 class="text-brand">Rp. {{ number_format($item['item_total']) }}</h4>
                                        </td>
                                        <td class="action text-center" data-title="Remove">
                                            <form method="POST" action="{{ route('cart.remove', $item['id']) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-body border-0 bg-transparent" 
                                                        onclick="return confirm('Remove this item from cart?')">
                                                    <i class="fi-rs-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="divider-2 mb-30"></div>
                        <div class="cart-action d-flex justify-content-between">
                            <a href="/products" class="btn">
                                <i class="fi-rs-arrow-left mr-10"></i>Continue Shopping
                            </a>
                            <button type="button" class="btn" onclick="location.reload()">
                                <i class="fi-rs-refresh mr-10"></i>Update Cart
                            </button>
                        </div>
                    @endif
                </div>
                
                <div class="col-lg-4">
                    @if(!empty($cartItems))
                        <div class="border p-md-4 cart-totals ml-30">
                            <div class="table-responsive">
                                <table class="table no-border">
                                    <tbody>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Subtotal</h6>
                                            </td>
                                            <td class="cart_total_amount subtotal">
                                                <h4 id="cart-subtotal" class="text-brand text-end">Rp. {{ number_format($totals['subtotal']) }}</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Shipping</h6>
                                            </td>
                                            <td class="cart_total_amount shipping">
                                                <h5 id="cart-shipping" class="text-heading text-end">
                                                    @if($totals['shipping'] == 0)
                                                        <span class="text-success">Free</span>
                                                    @else
                                                        Rp. {{ number_format($totals['shipping']) }}
                                                    @endif
                                                </h5>
                                            </td>
                                        </tr>
                                        @if($totals['shipping'] == 0 && $totals['subtotal'] > 0)
                                            <tr>
                                                <td colspan="2">
                                                    <small class="text-success">
                                                        <i class="fi-rs-gift mr-5"></i>Free shipping on orders over Rp. 500,000
                                                    </small>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Tax ({{ $totals['tax_rate'] }}%)</h6>
                                            </td>
                                            <td class="cart_total_amount tax">
                                                <h5 id="cart-tax" class="text-heading text-end">Rp. {{ number_format($totals['tax']) }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Total</h6>
                                            </td>
                                            <td class="cart_total_amount total">
                                                <h4 id="cart-total" class="text-brand text-end">Rp. {{ number_format($totals['total']) }}</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="/checkout" class="btn btn-primary btn-block w-100 mt-20">Proceed To CheckOut</a>
                        </div>
                        
                        @if(isset($outOfStockItems) && $outOfStockItems > 0)
                            <div class="alert alert-warning mt-20">
                                <strong>Notice:</strong> {{ $outOfStockItems }} item(s) in your cart are out of stock and won't be included in checkout.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script>
        function updateQuantity(productId, change) {
            const quantityInput = document.querySelector(`tr[data-product-id="${productId}"] .quantity-input`);
            const currentQuantity = parseInt(quantityInput.value);
            const newQuantity = Math.max(1, currentQuantity + change);
            const maxQuantity = parseInt(quantityInput.getAttribute('max'));
            
            if (newQuantity <= maxQuantity) {
                quantityInput.value = newQuantity;
                submitQuantityUpdate(productId, newQuantity);
            }
        }

        function updateQuantityInput(productId, quantity) {
            const quantityInput = document.querySelector(`tr[data-product-id="${productId}"] .quantity-input`);
            const maxQuantity = parseInt(quantityInput.getAttribute('max'));
            const newQuantity = Math.max(1, Math.min(quantity, maxQuantity));
            
            quantityInput.value = newQuantity;
            submitQuantityUpdate(productId, newQuantity);
        }

        function submitQuantityUpdate(productId, quantity) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/cart/${productId}/update-quantity`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the item total in the row
                    const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                    const itemTotalCell = row.querySelector('.item-total h4');
                    itemTotalCell.textContent = `${data.item_total}`;

                    // Update the cart totals
                    document.getElementById('cart-subtotal').textContent = data.subtotal;
                    document.getElementById('cart-shipping').textContent = data.shipping;
                    document.getElementById('cart-tax').textContent = data.tax;
                    document.getElementById('cart-total').textContent = data.total;

                    // Update the cart totals (reload page for simplicity)
                    // setTimeout(() => {
                    //     location.reload();
                    // }, 5000);
                } else {
                    toastr(data.message || 'Failed to update quantity');
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr('Failed to update quantity');
                location.reload();
            });
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear your cart?')) {
                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to clear cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to clear cart');
                });
            }
        }
    </script>
@endsection
