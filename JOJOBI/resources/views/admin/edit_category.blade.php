@extends('admin.layout')

<!-- Include Flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .text_cat {
        margin-bottom: 20px;
        text-align: center;
        font-weight: 700;
        font-size: 24px;
        color: #ddd;
    }

    form {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #ddd;
    }

    .form-group input {
        width: calc(100% - 22px);
        height: 40px;
        padding: 0 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #2d3035;
        color: #fff;
        /* Ensure text is visible on dark background */
    }

    .btn-primary {
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .table-container {
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table-deg {
        width: 100%;
        border-collapse: collapse;
    }

    .table-deg th,
    .table-deg td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .table-deg th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .table-deg tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table-deg tr:hover {
        background-color: #f1f1f1;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        padding-left: 0;
        list-style: none;
    }

    .pagination>li {
        display: inline;
    }

    .pagination>li>a,
    .pagination>li>span {
        padding: 8px 12px;
        margin-left: -1px;
        line-height: 1.5;
        color: #007bff;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .pagination>.active>a,
    .pagination>.active>span {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination>li>a:hover,
    .pagination>li>span:hover {
        background-color: #e9ecef;
        border-color: #ddd;
    }

    .calendar-icon {
        cursor: pointer;
    }
</style>

@section('content')
<div class="container">
    <h1 class="text_cat">Edit Category</h1>

    <!-- Edit Category Form -->
    <form action="{{ route('admin.category.update', $data->uuid) }}" method="post">
        @csrf

        <div class="form-group">
            <label for="category_name">Category Name</label>
            <input id="category_name" type="text" name="category_name" value="{{ $data->category_name }}" required
                autofocus autocomplete="category_name" />
            @if ($errors->has('category_name'))
                <span class="text-danger">{{ $errors->first('category_name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="category_barcode">Barcode</label>
            <input id="category_barcode" type="text" name="category_barcode" value="{{ $data->category_barcode }}"
                required autocomplete="category_barcode" />
            @if ($errors->has('category_barcode'))
                <span class="text-danger">{{ $errors->first('category_barcode') }}</span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary">Update Category</button>
        </div>
    </form>
</div>
@endsection
