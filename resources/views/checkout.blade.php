@extends('layouts.app')

@section('content')
<h1>Checkout</h1>
<h3>Confirm your order</h3>
<ul>
	@php
		$subtotal = 0;
		$grandtotal = 0;
	@endphp
		@if(session('cart'))
			@foreach(session('cart') as $id => $details)
				@php
					$subtotal += $details['price'] * $details['quantity'];
					$grandtotal += $subtotal;
				@endphp
				<li data-id="{{ $id }}">
					<div data-th="Product">
						<div class="row">
							<div class="col-sm-3 hidden-xs"><img src="{{ 'storage/photos/'.$details["image"] }}" width="100" height="100" class="img-responsive" /></div>
							<div class="col-sm-9">
								<h4 class="nomargin">{{ $details['name'] }}</h4>
							</div>
						</div>
					</div>
					<h4>Baba</h4>
					<h5 data-th="Price">{{ $details['price'] }}</h5>
					<h5 data-th="Quantity">{{ $details['quantity'] }}</h5>
					<h5>Subtotal: {{ $subtotal }}</h5>
					<h5>TOTAL: {{ $grandtotal }}</h5>
				</li>
			@endforeach
		@endif
	
</ul>


<form action="https://sandbox.payfast.co.za​/eng/process" method="post">
   	<input type="hidden" name="merchant_id" value="10000100">
	<input type="hidden" name="merchant_key" value="46f0cd694581a">
	<input type="hidden" name="return_url" value="https://b24f-41-246-143-226.ngrok.io/success">
	<input type="hidden" name="cancel_url" value="https://b24f-41-246-143-226.ngrok.io/cancel">
	<input type="hidden" name="notify_url" value="https://b24f-41-246-143-226.ngrok.io/notify">

   	<input type="hidden" name="amount" value="{{$grandtotal}}" />
   	<input type="hidden" name="item_name" value="The whole cart" />
   	<input type="submit" name="checkout" value="PAY NOW" />
</form>

@endsection