@extends('home.layout')

@section('content')
<div class="services-breadcrumb">
    <div class="agile_inner_breadcrumb">
        <div class="container">
            <ul class="w3_short">
                <li>
                    <a href="{{ route('home') }}">Home</a>
                    <i>|</i>
                    @if (session('came_from_all_products') && isset($product->categoryid))
                        <a href="{{ route('allProducts', ['categoryid' => $product->categoryid]) }}">Products</a>
                        <i>|</i>
                    @endif
                </li>
                <li> {{ $category->category_name }}</li>
            </ul>
        </div>
    </div>
</div>
    <div class="container">
        <h1 class="text-center my-4">All Products in {{ $category->category_name }}</h1>

        <div id="data-wrapper" class="row">
            @include('home.products.topProduct', ['products' => $products])
        </div>

        <div class="auto-load text-center my-4" style="display: none;">
            <p>Loading more products...</p>
        </div>

        @if ($products->hasMorePages())
            <div class=" show-more-container text-center my-4">
                <button id="load-more" data-next-page="{{ $products->currentPage() + 1 }}" class="btn btn-primary">Load More</button>
            </div>
        @endif
    </div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var ENDPOINT = "{{ url('/products/' . $category->categoryid) }}";

    function loadMore(page) {
        $.ajax({
            url: ENDPOINT + "?page=" + page,
            datatype: "html",
            type: "get",
            beforeSend: function () {
                $('.auto-load').show();
            }
        })
        .done(function (response) {
            if (response.trim() == '') {
                $('.auto-load').html("We don't have more data to display :(");
                $('#load-more').remove();
                return;
            }

            $('.auto-load').hide();
            $("#data-wrapper").append(response);

            var nextPage = $('#load-more').data('next-page');
            if (nextPage >= {{ $products->lastPage() }}) {
                $('#load-more').remove();
            } else {
                $('#load-more').data('next-page', nextPage + 1);
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occurred');
        });
    }

    $(document).ready(function() {
        $('#load-more').on('click', function() {
            var nextPage = $(this).data('next-page');
            loadMore(nextPage);
        });
    });
</script>



@endpush
