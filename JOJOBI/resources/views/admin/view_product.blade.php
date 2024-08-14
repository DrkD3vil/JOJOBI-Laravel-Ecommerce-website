@extends('admin.layout')

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
        background-color: #2d3035;
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
        background-color: #3a3f44;
        color: #fff;
    }

    .btn-primary {
        color: #fff;
        background-color: #007bff;
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
        background-color: #2d3035;
        color: #ddd;
        font-weight: bold;
    }

    .table-deg td {
        background-color: #3a3f44;
        color: #ddd;
    }

    .table-deg tr:nth-child(even) {
        background-color: #1A3636;
    }

    .table-deg tr:hover {
        color: #2d3035;
        background-color: #9CDBA6;
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

    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group-append {
        margin-left: -1px;
    }

    .input-group-text {
        background-color: #3a3f44;
        color: #fff;
        border: 1px solid #ccc;
        padding: 0 10px;
        border-radius: 0 4px 4px 0;
    }
</style>

@section('content')
<!-- Search Product Form -->
<h1 class="text_cat">Search Product</h1>
<form action="{{ route('admin.product.search') }}" method="GET">
    @csrf
    <div class="form-group input-group">
        <input type="text" name="search_term" id="searchTerm" class="form-control" placeholder="Search term">
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="fa fa-search"></i> <!-- FontAwesome search icon -->
            </span>
        </div>
    </div>
    <div class="form-group input-group mt-2">
        <input type="text" name="search_date" id="searchDate" class="form-control" placeholder="Search date (F d, Y)">
        <div class="input-group-append">
            <span class="input-group-text calendar-icon">
                <i class="fa fa-calendar"></i> <!-- FontAwesome calendar icon -->
            </span>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<!-- Display the total number of results -->
@if ($products->total() > 0)
    <p class="text-center">Total results found: {{ $products->total() }}</p>
@endif

<!-- Category Table -->
<div class="table-container">
    <table class="table-deg">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bar Code</th>
                <th>Product Name</th>
                <th>Category ID</th>
                <th>Category</th>
                <th>Image</th>
                <th>Original Price</th>
                <th>Sell Price</th>
                <th>Discount Price</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $item)
                <tr>
                    <td>{{ $item->productid }}</td>
                    <td>{{ $item->product_barcode }}</td>
                    <td>{!! Str::limit($item->product_name, 50) !!}</td>
                    <td>{!! Str::limit($item->categoryid) !!}</td>
                    
                    <td>{{ $item->category->category_name ?? 'N/A' }}</td> <!-- Display category name -->

                    <td><img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" width="100"></td>
                    <td>{{ $item->original_price }}</td>
                    <td>{{ $item->sell_price }}</td>
                    <td>{{ $item->discount }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y h:i A') }}</td>
                    <td>
                        <a class="btn btn-success" href="{{ url('update_product', $item->uuid) }}">Update</a>
                        <a class="btn btn-danger" onclick="confirmation(event)"
                            href="{{ url('delete_product', $item->uuid) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination">
        {{ $products->links() }}
    </div>
</div>

<!-- Pagination -->
<div class="pagination">
    <ul class="pagination">
        @if ($products->currentPage() > 1)
            <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}">Previous</a></li>
        @endif

        @for ($i = 1; $i <= $products->lastPage(); $i++)
            @if ($i == 1 || $i == $products->lastPage() || ($i >= $products->currentPage() - 2 && $i <= $products->currentPage() + 2))
                <li class="{{ $i == $products->currentPage() ? 'page-item active' : 'page-item' }}"><a class="page-link"
                        href="{{ $products->url($i) }}">{{ $i }}</a></li>
            @elseif ($i == $products->currentPage() - 3 || $i == $products->currentPage() + 3)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
        @endfor

        @if ($products->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}">Next</a></li>
        @endif
    </ul>
</div>




@endsection