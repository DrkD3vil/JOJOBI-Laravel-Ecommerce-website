<!-- Special Offers Section -->
<div class="featured-section" id="projects">
    <div class="container">
        <!-- Title Heading -->
        <h3 class="tittle-w3l">Special Offers
            <span class="heading-style">
                <i></i>
                <i></i>
                <i></i>
            </span>
        </h3>
        <!-- //Title Heading -->

        <!-- Content Bottom -->
        <div class="content-bottom-in">
            <ul id="flexiselDemo1">
                @foreach($specialOffers as $item)
                    <li>
                        <div class="w3l-specilamk">
                            <div class="speioffer-agile">
                                <a href="{{ url('productdetail', $item-> uuid)}}">
                                    <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" style="width: 15rem">
                                </a>
                            </div>
                            <div class="product-name-w3l">
                                <h4>
                                    <a href="{{ url('productdetail', $item-> uuid)}}">{{ $item->product_name }}</a>
                                </h4>
                                <div class="w3l-pricehkj">
                                    <h6>${{ number_format($item->sell_price, 2) }}</h6>
                                    <p>Save ${{ number_format($item->discount, 2) }}</p>
                                </div>
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="" method="post">
                                        @csrf
                                        <input type="hidden" name="item_name" value="{{ $item->product_name }}" />
                                        <input type="hidden" name="amount" value="{{ $item->sell_price }}" />
                                        <input type="hidden" name="discount_amount" value="{{ $item->discount }}" />
                                        <input type="submit" name="submit" value="Add to cart" class="button" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- //Content Bottom -->
    </div>
</div>
