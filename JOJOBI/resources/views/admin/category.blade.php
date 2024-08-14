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
        color: #fff; /* Ensure text is visible on dark background */
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
    thead{
        background-color: #2d3035;
        color: #000;
        font-weight: 700;
        text-align: center;
        padding: 10px;
        border-radius: 4px;
        font-size: 1.2rem;
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
        background-color: #1A3636;
    }

    .table-deg tr:hover {
        color: #2d3035;
        background-color: #9CDBA6;
        font-size: 1.2rem;
        font-weight: 700;
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
    <h1 class="text_cat">Add Category</h1>

    <!-- Add Category Form -->
    <form action="{{ route('admin.add_category') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="category_name">Category Name</label>
            <input id="category_name" type="text" name="category_name" value="{{ old('category_name') }}" required autofocus autocomplete="category_name" />
            @if ($errors->has('category_name'))
                <span class="text-danger">{{ $errors->first('category_name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="category_barcode">Barcode</label>
            <input id="category_barcode" type="text" name="category_barcode" value="{{ old('category_barcode') }}" required autocomplete="category_barcode" />
            @if ($errors->has('category_barcode'))
                <span class="text-danger">{{ $errors->first('category_barcode') }}</span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary">Add Category</button>
        </div>
    </form>

    <!-- Search Category Form -->
    <h1 class="text_cat">Search Category</h1>
    <form action="{{ route('admin.category.search') }}" method="GET">
        @csrf
        <div class="form-group input-group">
            <input 
                type="text" 
                name="search_term" 
                id="searchTerm" 
                class="form-control" 
                placeholder="Search term" 
            >
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="fa fa-search"></i> <!-- FontAwesome search icon -->
                </span>
            </div>
        </div>
        <div class="form-group input-group mt-2">
            <input 
                type="text" 
                name="search_date" 
                id="searchDate" 
                class="form-control" 
                placeholder="Search date (dd/mm/yyyy)" 
            >
            <div class="input-group-append">
                <span class="input-group-text calendar-icon">
                    <i class="fa fa-calendar"></i> <!-- FontAwesome calendar icon -->
                </span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Display the total number of results -->
    @if ($data->total() > 0)
        <p class="text-center">Total results found: {{ $data->total() }}</p>
    @endif

    <h1>PDF Actions</h1>
    <a href="{{ route('admin.preview-pdf') }}" target="_blank">Preview Categories PDF</a>
    <br>
    <a href="{{ route('admin.download-pdf') }}">Download Categories PDF</a>

<!-- Category Table -->
<div class="table-container">
    <table class="table-deg">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Category BarCode</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->categoryid }}</td>
                    <td>{{ $item->category_name }}</td>
                    <td>{{ $item->category_barcode }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</td>
                    <td>
                        <a class="btn btn-success" href="{{ route('admin.category.edit', $item->uuid) }}">Edit</a>
                        <a class="btn btn-danger" onclick="confirmation(event)" href="{{ route('admin.category.delete', $item->uuid) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    <!-- Pagination -->
    <div class="pagination">
        <ul class="pagination">
            @if ($data->currentPage() > 1)
                <li class="page-item"><a class="page-link" href="{{ $data->previousPageUrl() }}">Previous</a></li>
            @endif

            @for ($i = 1; $i <= $data->lastPage(); $i++)
                @if ($i == 1 || $i == $data->lastPage() || ($i >= $data->currentPage() - 2 && $i <= $data->currentPage() + 2))
                    <li class="{{ $i == $data->currentPage() ? 'page-item active' : 'page-item' }}"><a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a></li>
                @elseif ($i == $data->currentPage() - 3 || $i == $data->currentPage() + 3)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endfor

            @if ($data->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $data->nextPageUrl() }}">Next</a></li>
            @endif
        </ul>
    </div>
</div>
@endsection

