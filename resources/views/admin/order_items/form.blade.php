<div class="form-group">
  <label for="number">Number</label>
  {!! Form::text('number', null, ['class'=>'form-control', 'id'=>'number', 'placeholder'=>'Number', 'required']) !!}
</div>
<div class="form-group">
  <label for="order_id">Order_id</label>
  {!! Form::text('order_id', null, ['class'=>'form-control', 'id'=>'order_id', 'placeholder'=>'Order_id', 'required']) !!}
</div>
<div class="form-group">
  <label for="order_number">Order_number</label>
  {!! Form::text('order_number', null, ['class'=>'form-control', 'id'=>'order_number', 'placeholder'=>'Order_number', 'required']) !!}
</div>
<div class="form-group">
  <label for="seller_sku">Seller_sku</label>
  {!! Form::text('seller_sku', null, ['class'=>'form-control', 'id'=>'seller_sku', 'placeholder'=>'Seller_sku', 'required']) !!}
</div>
<div class="form-group">
  <label for="lazada_sku">Lazada_sku</label>
  {!! Form::text('lazada_sku', null, ['class'=>'form-control', 'id'=>'lazada_sku', 'placeholder'=>'Lazada_sku', 'required']) !!}
</div>
<div class="form-group">
  <label for="details">Details</label>
  {!! Form::text('details', null, ['class'=>'form-control', 'id'=>'details', 'placeholder'=>'Details', 'required']) !!}
</div>
<div class="form-group">
  <label for="shipping_provider">Shipping_provider</label>
  {!! Form::text('shipping_provider', null, ['class'=>'form-control', 'id'=>'shipping_provider', 'placeholder'=>'Shipping_provider', 'required']) !!}
</div>
<div class="form-group">
  <label for="delivery_status">Delivery_status</label>
  {!! Form::text('delivery_status', null, ['class'=>'form-control', 'id'=>'delivery_status', 'placeholder'=>'Delivery_status', 'required']) !!}
</div>
<div class="form-group">
  <label for="subtotal">Subtotal</label>
  {!! Form::text('subtotal', null, ['class'=>'form-control', 'id'=>'subtotal', 'placeholder'=>'Subtotal', 'required']) !!}
</div>
<div class="form-group">
  <label for="shipping_paid">Shipping_paid</label>
  {!! Form::text('shipping_paid', null, ['class'=>'form-control', 'id'=>'shipping_paid', 'placeholder'=>'Shipping_paid', 'required']) !!}
</div>
<div class="form-group">
  <label for="shipping_charged">Shipping_charged</label>
  {!! Form::text('shipping_charged', null, ['class'=>'form-control', 'id'=>'shipping_charged', 'placeholder'=>'Shipping_charged', 'required']) !!}
</div>
<div class="form-group">
  <label for="payment_fee">Payment_fee</label>
  {!! Form::text('payment_fee', null, ['class'=>'form-control', 'id'=>'payment_fee', 'placeholder'=>'Payment_fee', 'required']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminOrderItems')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>