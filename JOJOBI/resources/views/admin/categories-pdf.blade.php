<!DOCTYPE html>
<html>
<head>
    <title>Categories PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Categories List</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category ID</th>
                    <th>UUID</th>
                    <th>Category Name</th>
                    <th>Category Barcode</th>
                    <th>Created Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->categoryid }}</td>
                        <td>{{ $category->uuid }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->category_barcode }}</td>
                        <td>{{ \Carbon\Carbon::parse($category->created_at)->format('F d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
