@extends('admin.layout')

<style>
    .container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 10px;
        font-size: 16px;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-check label {
        margin: 0;
    }

    .btn {
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .text_cat {
        margin-bottom: 20px;
        text-align: center;
        color: white;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .text-danger {
        color: red;
        font-size: 0.875rem;
    }

    #image-preview-container {
        margin-top: 10px;
        display: none;
    }

    #image-preview {
        max-width: 100%;
        height: auto;
        display: block;
    }
</style>

@section('content')
<div class="container">
    <h1 class="text_cat">Edit Product</h1>

    <form action="{{ route('admin.product.edit', $product->uuid) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="product_barcode">Bar Code</label>
            <input id="product_barcode" type="text" class="form-control" name="product_barcode"
                placeholder="Enter Bar Code" value="{{ old('product_barcode', $product->product_barcode) }}" required
                autofocus autocomplete="product_barcode" />
            @if ($errors->has('product_barcode'))
                <span class="text-danger">{{ $errors->first('product_barcode') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" class="form-control" name="product_name"
                placeholder="Enter Product Name" value="{{ old('product_name', $product->product_name) }}" required>
            @if ($errors->has('product_name'))
                <span class="text-danger">{{ $errors->first('product_name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="description">Product Description</label>
            <textarea id="description" class="form-control" name="description" placeholder="Enter Product Description"
                required>{{ old('description', $product->description) }}</textarea>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="product_image">Product Image</label>
            @if ($product->product_image)
                <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" width="200">
            @endif
            <input type="file" id="product_image" class="form-control" name="product_image"
                placeholder="Enter product Image" accept="image/*">
            @if ($errors->has('product_image'))
                <span class="text-danger">{{ $errors->first('product_image') }}</span>
            @endif
            <div id="image-preview-container">
                <img id="image-preview" src="" alt="Image Preview" width="200">
            </div>
        </div>

        <div class="form-group">
            <label for="original_price">Original Price</label>
            <input type="number" id="original_price" class="form-control" name="original_price"
                placeholder="Enter Original Price" step="0.01"
                value="{{ old('original_price', $product->original_price) }}" required>
            @if ($errors->has('original_price'))
                <span class="text-danger">{{ $errors->first('original_price') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" id="discount" class="form-control" name="discount" placeholder="Enter Discount"
                step="0.01" min="0" value="{{ old('discount', $product->discount) }}">
            @if ($errors->has('discount'))
                <span class="text-danger">{{ $errors->first('discount') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="sell_price">Sell Price</label>
            <input type="number" id="sell_price" class="form-control" name="sell_price" placeholder="Sell Price"
                step="0.01" readonly value="{{ old('sell_price', $product->sell_price) }}">
            @if ($errors->has('sell_price'))
                <span class="text-danger">{{ $errors->first('sell_price') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="categoryid">Category</label>
            <select id="categoryid" name="categoryid" class="form-control" required>
                <option value="">Select a Category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->categoryid }}" {{ old('categoryid', $product->categoryid) == $cat->categoryid ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('categoryid'))
                <span class="text-danger">{{ $errors->first('categoryid') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="product_quantity">Quantity</label>
            <input type="number" id="product_quantity" class="form-control" name="product_quantity"
                placeholder="Enter Quantity" required min="1" value="{{ old('product_quantity', $product->quantity) }}">
            @if ($errors->has('product_quantity'))
                <span class="text-danger">{{ $errors->first('product_quantity') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label>Product Status</label>
            <div class="form-check">
                <input type="checkbox" id="is_new" name="is_new" value="1" class="form-check-input" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                <label for="is_new" class="form-check-label">New</label>
            </div>

            <div class="form-check">
                <input type="checkbox" id="is_on_discount" name="is_on_discount" value="1" class="form-check-input" {{ old('is_on_discount', $product->is_on_discount) ? 'checked' : '' }}>
                <label for="is_on_discount" class="form-check-label">Discounted</label>
            </div>

            @if ($errors->has('is_new') || $errors->has('is_on_discount'))
                <span class="text-danger">{{ $errors->first('is_new') ?? $errors->first('is_on_discount') }}</span>
            @endif
        </div>


        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<script>
    document.getElementById('product_image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                const imagePreview = document.getElementById('image-preview');
                imagePreview.src = event.target.result;
                document.getElementById('image-preview-container').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('image-preview-container').style.display = 'none';
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const originalPriceInput = document.getElementById('original_price');
        const discountInput = document.getElementById('discount');
        const sellPriceInput = document.getElementById('sell_price');
        const statusInputs = document.querySelectorAll('input[name="status"]');

        function calculateSellPrice() {
            const originalPrice = parseFloat(originalPriceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            if (document.querySelector('input[name="status"]:checked')?.value === 'is_on_discount') {
                const sellPrice = Math.max(originalPrice - discount, 0);
                sellPriceInput.value = sellPrice.toFixed(2);
                sellPriceInput.readOnly = true;
            } else {
                sellPriceInput.readOnly = false;
            }
        }

        originalPriceInput.addEventListener('input', calculateSellPrice);
        discountInput.addEventListener('input', calculateSellPrice);

        statusInputs.forEach(radio => {
            radio.addEventListener('change', calculateSellPrice);
        });

        calculateSellPrice(); // Initial calculation
    });
</script>
@endsection