<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px; /* Reduce font size */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px; /* Reduce padding */
            text-align: left;
            word-wrap: break-word; /* Allow line breaks within words */
        }
        th {
            background-color: #f2f2f2; /* Light gray background for header */
        }
        td {
            font-size: 10px; /* Further reduce font size for table data */
        }
        .product-image {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <h1>Product List</h1>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Barcode</th>
                <th>Name</th>
                <th>Product Image</th>
                <th>Original Price</th>
                <th>Sell Price</th>
                <th>Discount</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Supplier</th>
                <th>Quantity</th>
                <th>New</th>
                <th>On Discount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->productid }}</td>
                    <td>{{ $product->product_barcode }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>
                        @if($product->product_image && file_exists(public_path($product->product_image)))
                            <img src="{{ public_path($product->product_image) }}" alt="{{ $product->product_name }}" class="product-image">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $product->original_price }}</td>
                    <td>{{ $product->sell_price }}</td>
                    <td>{{ $product->discount }}</td>
                    <td>{{ $product->category->category_name }}</td> <!-- Assuming you have a relationship set up -->
                    <td>{{ $product->brand }}</td>
                    <td>{{ $product->supplier }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->is_new ? 'Yes' : 'No' }}</td>
                    <td>{{ $product->is_on_discount ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
