<script>
    function addToCart(productId, quantity, token) {
        // create execute submit form but stay in this page
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/cart';
        form.style.display = 'none';
        const inputProductId = document.createElement('input');
        inputProductId.type = 'hidden';
        inputProductId.name = 'product_id';
        inputProductId.value = productId;
        const inputQuantity = document.createElement('input');
        inputQuantity.type = 'hidden';
        inputQuantity.name = 'quantity';
        inputQuantity.value = quantity;
        // add csrf token
        const inputCsrf = document.createElement('input');
        inputCsrf.type = 'hidden';
        inputCsrf.name = '_token';
        inputCsrf.value = token;
        form.appendChild(inputCsrf);
        form.appendChild(inputProductId);
        form.appendChild(inputQuantity);
        document.body.appendChild(form);
        form.submit();
        toastr.success('Product added to Cart');
    }
    function addToWishlist(productId, token) {
        // create execute submit form but stay in this page
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/wishlist';
        form.style.display = 'none';
        const inputProductId = document.createElement('input');
        inputProductId.type = 'hidden';
        inputProductId.name = 'product_id';
        inputProductId.value = productId;
        const inputCsrf = document.createElement('input');
        inputCsrf.type = 'hidden';
        inputCsrf.name = '_token';
        inputCsrf.value = token;
        form.appendChild(inputCsrf);
        form.appendChild(inputProductId);
        document.body.appendChild(form);
        form.submit();
        toastr.success('Product added to Wishlist');
    }
</script>
