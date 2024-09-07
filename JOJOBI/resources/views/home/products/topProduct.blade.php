@foreach ($products as $item)
    <div class="col-md-4 product-men">
        <div class="men-pro-item simpleCart_shelfItem">
            <div class="men-thumb-item">
            <img src="{{ asset($item->product_image) }}" alt="" style="width: 15rem">
                <div class="men-cart-pro">
                    <div class="inner-men-cart-pro">
                        <a href="{{ url('productdetail', $item-> uuid)}}" class="link-product-add-cart">Quick View</a>
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
                            <input type="hidden" name="item_name" value="{{$item->product_name}}" />
                            <input type="hidden" name="amount" value="{{$item->sell_price}}" />
                            <input type="hidden" name="discount_amount" value="1.00" />
                            <input type="hidden" name="currency_code" value="BDT" />
                            <input type="submit" name="submit" value="Add to cart" class="button" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
