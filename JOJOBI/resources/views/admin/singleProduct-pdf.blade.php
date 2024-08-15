<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .details {
            width: 50%;
            padding: 10px;
            box-sizing: border-box;
        }

        .image {
            text-align: center;
            box-sizing: border-box;
            background-color: #f9f9f9;
            display: flex;
        }

        .image img {
            max-width: 30%;
            border-radius: 8px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        td {
            font-size: 14px;
            color: #555;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .details,
            .image {
                width: 100%;
            }

            .details {
                padding: 10px;
            }

            .image {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <h1>{{ $product->product_name }} Details</h1>
    <div class="container">
    <div class="image">
            @if($product->product_image && file_exists(public_path($product->product_image)))
            <img src="{{ public_path($product->product_image) }}" alt="{{ $product->product_name }}">
            @else
            <p>No Image Available</p>
            @endif
        </div>
        <div class="details">
            <table>
                <tr>
                    <th>Product ID</th>
                    <td>{{ $product->productid }}</td>
                </tr>
                <tr>
                    <th>Barcode</th>
                    <td>{{ $product->product_barcode }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $product->product_name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $product->description }}</td>
                </tr>
                <tr>
                    <th>Original Price</th>
                    <td>{{ $product->original_price }}</td>
                </tr>
                <tr>
                    <th>Sell Price</th>
                    <td>{{ $product->sell_price }}</td>
                </tr>
                <tr>
                    <th>Discount</th>
                    <td>{{ $product->discount }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $product->category->category_name }}</td>
                </tr>
                <tr>
                    <th>Brand</th>
                    <td>{{ $product->brand }}</td>
                </tr>
                <tr>
                    <th>Supplier</th>
                    <td>{{ $product->supplier }}</td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td>{{ $product->quantity }}</td>
                </tr>
                <tr>
                    <th>New</th>
                    <td>{{ $product->is_new ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <th>On Discount</th>
                    <td>{{ $product->is_on_discount ? 'Yes' : 'No' }}</td>
                </tr>
            </table>
        </div>
        
    </div>
</body>

</html>
