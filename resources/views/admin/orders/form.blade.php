<div class="form-group">
  <label for="number">Number</label>
  {!! Form::text('number', null, ['class'=>'form-control', 'id'=>'number', 'placeholder'=>'Number', 'required']) !!}
</div>
<div class="form-group">
  <label for="date">Date</label>
  {!! Form::text('date', null, ['class'=>'form-control', 'id'=>'date', 'placeholder'=>'Date']) !!}
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
<div class="form-group">
  <label for="total">Total</label>
  {!! Form::text('total', null, ['class'=>'form-control', 'id'=>'total', 'placeholder'=>'Total', 'required']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminOrders')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>