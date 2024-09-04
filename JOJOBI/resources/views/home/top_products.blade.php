<div class="ads-grid">
    <div class="container">
        <!-- tittle heading -->
        <h3 class="tittle-w3l">Our Top Products
            <span class="heading-style">
                <i></i>
                <i></i>
                <i></i>
            </span>
        </h3>
        <!-- //tittle heading -->
        <!-- product left -->
        <div class="side-bar col-md-3">
            <div class="search-hotel">
                <h3 class="agileits-sear-head">Search Here..</h3>
                <form id="search-form" action="#" method="get">
                    <input type="search" placeholder="Product name..." name="search" id="search-input" value="{{ request('search') }}">
                    <input type="submit" value=" ">
                </form>
            </div>
            <!-- price range -->
            <div class="range">
                <h3 class="agileits-sear-head">Price range</h3>
                <ul class="dropdown-menu6">
                    <li>
                        <div id="slider-range"></div>
                        <input type="text" id="amount" readonly style="border: 0; color: #ffffff; font-weight: normal;" />
                    </li>
                </ul>
            </div>
            <!-- //price range -->
        </div>
        <!-- //product left -->
        <!-- product right -->
        <div class="agileinfo-ads-display col-md-9">
            <div class="wrapper">
            <div id="products-container">
    @foreach($categoryProducts as $categoryName => $products)
        <div id="product-section-{{ Str::slug($categoryName) }}" class="product-sec1"
             data-category-id="{{ $products->first()->categoryid }}">
            <h3 class="heading-tittle">{{ $categoryName }}</h3>
            <div id="product-container-{{ Str::slug($categoryName) }}" class="content_product" style="border-bottom-style: outset;">
                @include('home.products.topProduct', ['products' => $products])
            </div>
            <div class="show-more-container">
                <a href="{{ route('allProducts', ['categoryid' => $products->first()->categoryid]) }}" class="btn btn-primary">Show More</a>
            </div>
        </div>
    @endforeach
</div>

            </div>
        </div>
        <!-- //product right -->
    </div>
</div>
