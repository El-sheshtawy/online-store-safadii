@if($items->isNotEmpty())
<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items">{{ $items->count() }}</span>
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{ $items->count() }} Items</span>
            <a href="{{ route('cart.index') }}">
                View Cart
            </a>
        </div>
        <ul class="shopping-list">
            @foreach($items as $item)
            <li>
                <a href="javascript:void(0)" class="remove" title="Remove this item"><i
                        class="lni lni-close"></i></a>
                <div class="cart-img-head">
                    <a class="cart-img" href="{{ url('/product/'.$item->slug) }}">
                        <img src={{ $item->product->image_url }} alt="#">
                    </a>
                </div>

                <div class="content">
                    <h4>
                        <a href="{{ url('/product/'.$item->slug) }}">
                            {{ $item->product->name }}
                        </a>
                    </h4>
                    @if($item->product->compare_price)
                        <p class="quantity">Quantity: {{ $item->quantity }}
                            <span class="amount">Discount: {{ Currency::formatAppCurrency($item->product->compare_price )}}
                            </span>
                        </p>
                    @else
                        <p class="quantity">
                            Quantity: {{ $item->quantity }}
                            <span class="amount">Price: {{ Currency::formatAppCurrency($item->product->price )}}
                            </span>
                        </p>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
        <div class="bottom">
            <div class="total">
                <span>Total</span>
                <span class="total-amount">{{ Currency::formatAppCurrency($total) }}</span>
            </div>
            <div class="button">
                <a href="{{ route('stripe.show') }}" class="btn animate">Checkout</a>
            </div>
        </div>
    </div>
    <!--/ End Shopping Item -->
</div>
@else
    <div class="cart-items">
        <a href="javascript:void(0)" class="main-btn">
            <i class="lni lni-cart"></i>
            <span class="total-items">0 Items</span>
        </a>
        <!-- Shopping Item -->
        <div class="shopping-item">
            <div style="text-align: center; font-weight: bold" >
                <span> 0 Items</span>
            </div>
            <br>
              <h8 style="text-align: center">Your Cart art is empty now</h8>
            </div>
        </div>
@endif
