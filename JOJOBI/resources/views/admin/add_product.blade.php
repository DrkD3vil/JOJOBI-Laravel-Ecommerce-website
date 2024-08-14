@extends('admin.layout')

<!-- Include Flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <h1 class="text_cat">Add Product</h1>

    <!-- Add Product Form -->
    <form action="{{ route('admin.product.upload') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="product_barcode">Bar Code</label>
            <input id="product_barcode" type="text" class="form-control" name="product_barcode"
                placeholder="Enter Bar Code" value="{{ old('product_barcode') }}" required autofocus
                autocomplete="product_barcode" />
            @error('product_barcode')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" class="form-control" name="product_name"
                placeholder="Enter Product Name" value="{{ old('product_name') }}">
            @error('product_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Product Description</label>
            <textarea id="description" class="form-control" name="description" placeholder="Enter Product Description">
                {{ old('description') }}
            </textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="product_image">Product Image</label>
            <input type="file" id="product_image" class="form-control" name="product_image"
                accept="image/*">
            @error('product_image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div id="image-preview-container">
                <img id="image-preview" src="" alt="Image Preview">
            </div>
        </div>

        <div class="form-group">
            <label for="categoryid">Category</label>
            <select id="categoryid" name="categoryid" class="form-control" required>
                <option value="">Select a Category</option>
                @foreach ($categories as $cat)
                    <option  value="{{ $cat->categoryid }}" {{ old('categoryid') == $cat->categoryid ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
            @error('categoryid')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="original_price">Original Price</label>
            <input type="number" id="original_price" class="form-control" name="original_price"
                placeholder="Enter Original Price" step="0.01" value="{{ old('original_price') }}">
            @error('original_price')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" id="discount" class="form-control" name="discount" placeholder="Enter Discount"
                step="0.01" min="0" value="{{ old('discount') }}">
            @error('discount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="sell_price">Sell Price</label>
            <input type="number" id="sell_price" class="form-control" name="sell_price" placeholder="Sell Price"
                step="0.01" readonly>
            @error('sell_price')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Product Status</label>
            @foreach (['is_new' => 'New', 'is_on_discount' => 'Discounted'] as $value => $label)
                <div class="form-check">
                    <input type="radio" id="{{ $value }}" name="status" value="{{ $value }}" class="form-check-input" {{ old('status') === $value ? 'checked' : '' }} required>
                    <label for="{{ $value }}" class="form-check-label">{{ $label }}</label>
                </div>
            @endforeach
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" class="form-control" name="quantity"
                placeholder="Enter Quantity" required min="1" value="{{ old('quantity') }}">
            @error('quantity')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" id="brand" class="form-control" name="brand"
                placeholder="Enter Brand" value="{{ old('brand') }}">
            @error('brand')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="supplier">Supplier</label>
            <input type="text" id="supplier" class="form-control" name="supplier"
                placeholder="Enter Supplier" value="{{ old('supplier') }}">
            @error('supplier')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary form-control" value="Add Product">
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('product_image');
        const imagePreview = document.getElementById('image-preview');
        const imagePreviewContainer = document.getElementById('image-preview-container');

        // Handle new file selection
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreviewContainer.style.display = 'none';
            }
        });

        // Display the preview if an image URL is set
        if (fileInput.files.length > 0) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.style.display = 'block';
            }
            reader.readAsDataURL(fileInput.files[0]);
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
