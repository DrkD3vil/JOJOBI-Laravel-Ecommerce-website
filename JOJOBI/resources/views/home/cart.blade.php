@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>
    
    <!-- Check if there are items in the cart -->
    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" style="width: 100px;">
                            {{ $item->product->name }}
                        </td>
                        <td>${{ number_format($item->product->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        <td>
                            <!-- Add a form to remove item from the cart -->
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <h3>Total: ${{ number_format($cartTotal, 2) }}</h3>
            <a href="{{ route('checkout.page') }}" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    @endif
</div>
@endsection
