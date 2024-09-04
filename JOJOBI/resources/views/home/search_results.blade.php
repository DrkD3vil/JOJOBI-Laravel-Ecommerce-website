
@extends('home.layout')

@section('content')

<div class="ads-grid">
    <div class="container">
        <!-- tittle heading -->
        <h3 class="tittle-w3l">Search Results for "{{ $searchTerm }}"
            <span class="heading-style">
                <i></i>
                <i></i>
                <i></i>
            </span>
        </h3>
        <!-- //tittle heading -->
        <!-- product left -->
        <!-- The search form can be repeated here if needed -->
        <!-- //product left -->
        <!-- product right -->
        <div class="agileinfo-ads-display col-md-12">
            <div class="wrapper">
                @foreach($products as $item)
                    <div class="col-md-4 product-men">
                        <div class="men-pro-item simpleCart_shelfItem">
                            <div class="men-thumb-item">
                                <img src="{{ asset($item->product_image) }}" alt="" style="width: 15rem">
                                <div class="men-cart-pro">
                                    <div class="inner-men-cart-pro">
                                        <a href="{{ url('productdetail', $item->uuid) }}" class="link-product-add-cart">Quick View</a>
                                    </div>
                                </div>
                                <span class="product-new-top">New</span>
                            </div>
                            <div class="item-info-product">
                                <h4 class="product-title">
                                    <a href="single.html">{{ $item->product_name }}</a>
                                </h4>
                                <div class="info-product-price">
                                    <span class="item_price">{{ $item->sell_price }}</span>
                                    <del>${{ $item->original_price }}</del>
                                </div>
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart" />
                                            <input type="hidden" name="add" value="1" />
                                            <input type="hidden" name="business" value=" " />
                                            <input type="hidden" name="item_name" value="{{ $item->product_name }}" />
                                            <input type="hidden" name="amount" value="{{ $item->sell_price }}" />
                                            <input type="hidden" name="discount_amount" value="{{ $item->discount }}" />
                                            <input type="hidden" name="currency_code" value="USD" />
                                            <input type="hidden" name="return" value=" " />
                                            <input type="hidden" name="cancel_return" value=" " />
                                            <input type="submit" name="submit" value="Add to cart" class="button" />
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Pagination links -->
                {{ $products->links() }}
            </div>
        </div>
        <!-- //product right -->
    </div>
</div>

@endsection

