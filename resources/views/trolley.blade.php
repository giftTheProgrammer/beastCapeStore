@extends('layouts.app')

@section('content')

<table id="cart-list">
	<thead>
		<tr>
			<th style="width:40%" colspan="2" class="text-center">Artwork</th>
			<th style="width:30%">Artist</th>
			<th style="width:10%">Price</th>
			<th style="width:10%"></th>
		</tr>
	</thead>
	<tbody>
		@php $total = 0; @endphp
		@if(session('cart'))
			@foreach(session('cart') as $id => $details)
				@php $total =+ $details['price'] * $details['quantity'] @endphp
				<tr data-id="{{ $id }}">
					<td data-th="Product" colspan="2">
						<div class="row">
							<div class="col-4 col-lg-4 hidden-xs"><img src="{{ 'storage/photos/'.$details["image"] }}" class="img-responsive" /></div>
							<div class="col-8 col-lg-8">
								<h4>{{ $details['name'] }}</h4>
							</div>
						</div>
					</td>
					<td data-th="Artist">{{ $details['artist'] }}</td>
					<td data-th="Price">{{ $details['price'] }}</td>
					<td>
						
		            <button class="btn btn-danger remove-from-cart">Remove</button>
					</td>
				</tr>
			@endforeach
		@endif
		
	</tbody>
	
</table>


<a href="/checkout" id="checkout">Checkout</a>

<script type="text/javascript">
	$(".btn.btn-danger.remove-from-cart").click(function(e){
		e.preventDefault();

		var ele = $(this);

		if (confirm("Are you sure you want to remove this item?")) {
			$.ajax({
				url: '{{ route('remove.from.cart') }}', method: "DELETE",
				data: {_token: '{{ csrf_token() }}', id: ele.parents("tr").attr("data-id")},
				success: function(response){
					window.location.reload();
				}
			})
		}
	});
</script>

@endsection()