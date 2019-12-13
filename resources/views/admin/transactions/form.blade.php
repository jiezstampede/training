<div class="form-group">
  <label for="number">Number</label>
  {!! Form::text('number', null, ['class'=>'form-control', 'id'=>'number', 'placeholder'=>'Number', 'required']) !!}
</div>
<div class="form-group">
  <label for="date">Date</label>
  {!! Form::text('date', null, ['class'=>'form-control', 'id'=>'date', 'placeholder'=>'Date']) !!}
</div>
<div class="form-group">
  <label for="type">Type</label>
  {!! Form::text('type', null, ['class'=>'form-control', 'id'=>'type', 'placeholder'=>'Type', 'required']) !!}
</div>
<div class="form-group">
  <label for="fee_name">Fee_name</label>
  {!! Form::text('fee_name', null, ['class'=>'form-control', 'id'=>'fee_name', 'placeholder'=>'Fee_name', 'required']) !!}
</div>
<div class="form-group">
  <label for="amount">Amount</label>
  {!! Form::text('amount', null, ['class'=>'form-control', 'id'=>'amount', 'placeholder'=>'Amount', 'required']) !!}
</div>
<div class="form-group">
  <label for="vat">Vat</label>
  {!! Form::text('vat', null, ['class'=>'form-control', 'id'=>'vat', 'placeholder'=>'Vat', 'required']) !!}
</div>
<div class="form-group">
  <label for="wht">Wht</label>
  {!! Form::text('wht', null, ['class'=>'form-control', 'id'=>'wht', 'placeholder'=>'Wht', 'required']) !!}
</div>
<div class="form-group">
  <label for="paid_status">Paid_status</label>
  {!! Form::text('paid_status', null, ['class'=>'form-control', 'id'=>'paid_status', 'placeholder'=>'Paid_status', 'required']) !!}
</div>
<div class="form-group">
  <label for="order_number">Order_number</label>
  {!! Form::text('order_number', null, ['class'=>'form-control', 'id'=>'order_number', 'placeholder'=>'Order_number', 'required']) !!}
</div>
<div class="form-group">
  <label for="order_item_number">Order_item_number</label>
  {!! Form::text('order_item_number', null, ['class'=>'form-control', 'id'=>'order_item_number', 'placeholder'=>'Order_item_number', 'required']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminTransactions')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>