<x-front-layout title="Cart">
    <x-slot:breadcrumb>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title"></h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i>Home</a></li>
                            <li><a href="{{ route('products.index') }}"><i class="lni lni-home"></i>Shop</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot:breadcrumb>


                <!-- Shopping Cart -->
                <div class="shopping-cart section">
                    <div class="container">
                        <div class="cart-list-head">
                            <!-- Cart List Title -->
                            <div class="cart-list-title">
                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-12">

                                    </div>
                                    <div class="col-lg-4 col-md-3 col-12">
                                        <p>Product Name</p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <p>Quantity</p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <p>Subtotal</p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <p>Discount</p>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-12">
                                        <p>Remove</p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Cart List Title -->

                            @foreach($items as $item)
                                <div class="cart-single-list" id="{{ $item->id }}">
                                    <div class="row align-items-center">
                                        <div class="col-lg-1 col-md-1 col-12">
                                            <a href="">
                                                <img src="{{ $item->product->image_url }}" alt="#">
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-3 col-12">
                                            <h5 class="product-name">
                                                <a href="{{ route('product.show' ,$item->product->slug) }}">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h5>
                                            <p class="product-des">
                                                <span><em>Type:</em> Mirrorless</span>
                                                <span><em>Color:</em> Black</span>
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-12">
                                            <div class="count-input">
                                                <input class="form-control item-quantity"
                                                       data-id="{{ $item->id }}"
                                                       value="{{ $item->quantity }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-12">
                                            <p>
                                                {{ Currency::formatAppCurrency($item->quantity * $item->product->compare_price ?? $item->product->price) }}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-12">
                                            <p>0</p>
                                        </div>
                                        <div class="col-lg-1 col-md-2 col-12">
                                            <a class="remove-item" data-id="{{ $item->id}}" href="javascript:void(0)">
                                                <i class="lni lni-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

          <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="#" target="_blank">
                                            <input name="Coupon" placeholder="Enter Your Coupon">
                                            <div class="button">
                                                <button class="btn">Apply Coupon</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li>
                                            Cart Subtotal
                                            <span>
                                                {{ Currency::formatAppCurrency(\App\Http\Facades\Cart::total()) }}
                                            </span>
                                        </li>
                                        <li>Shipping<span>Free</span></li>
                                        <li>You Save<span>$29.00</span></li>
                                        <li class="last">You Pay<span>$2531.00</span></li>
                                    </ul>
                                    <div class="button">
                                        <a href="{{ route('order.create') }}" class="btn">Make the order</a>
                                        <a href="{{ route('stripe.show') }}" class="btn">Checkout</a>
                                        <a href="{{ route('home') }}" class="btn btn-alt">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->
  </div>

    @push('scripts')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

        <script>
            const csrf_token = "{{ csrf_token() }}";
        </script>

        <script>
            (function ($) {

                $('.item-quantity').on('change', function (){
                    $.ajax({
                        url: "/cart/" + $(this).data('id'), //data-id
                        method: 'put',
                        data: {
                            quantity: $(this).val(),
                            _token: csrf_token
                        }
                    });
                });

                $('.remove-item').on('click', function (){
                    let id= $(this).data('id');
                    $.ajax({
                        url: "/cart/" + id, //data-id
                        method: 'delete',
                        data: {
                            _token: csrf_token
                        },
                        success: response => {
                            $(`#${id}`).remove();
                        }
                    });
                });

                $('.add-to-cart').on('click', function (){
                    let id= $(this).data('id');
                    $.ajax({
                        url: "/cart", //data-id
                        method: 'post',
                        data: {
                            product_id:$(this).data('id'),
                            quantity:$(this).data('quantity'),
                            _token: csrf_token
                        },
                        success: response => {
                            alert('product added')
                        }
                    });
                });

            })(jQuery);
        </script>
    @endpush
</x-front-layout>
