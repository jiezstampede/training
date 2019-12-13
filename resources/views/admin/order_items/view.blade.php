@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminOrderItems')}}">Order Items</a></li>
  <li class="active">View</li>
</ol>
@stop

@section('content')
<div class="col-md-8">
	<table class='table table-striped table-bordered table-view'>
		<tr>
			<th>Id</th>
			<td>{!!$data->id!!}</td>
		</tr>
		<tr>
			<th>Number</th>
			<td>{!!$data->number!!}</td>
		</tr>
		<tr>
			<th>Order id</th>
			<td>{!!$data->order_id!!}</td>
		</tr>
		<tr>
			<th>Order number</th>
			<td>{!!$data->order_number!!}</td>
		</tr>
		<tr>
			<th>Seller sku</th>
			<td>{!!$data->seller_sku!!}</td>
		</tr>
		<tr>
			<th>Lazada sku</th>
			<td>{!!$data->lazada_sku!!}</td>
		</tr>
		<tr>
			<th>Details</th>
			<td>{!!$data->details!!}</td>
		</tr>
		<tr>
			<th>Shipping provider</th>
			<td>{!!$data->shipping_provider!!}</td>
		</tr>
		<tr>
			<th>Delivery status</th>
			<td>{!!$data->delivery_status!!}</td>
		</tr>
		<tr>
			<th>Subtotal</th>
			<td>{!!$data->subtotal!!}</td>
		</tr>
		<tr>
			<th>Shipping paid</th>
			<td>{!!$data->shipping_paid!!}</td>
		</tr>
		<tr>
			<th>Shipping charged</th>
			<td>{!!$data->shipping_charged!!}</td>
		</tr>
		<tr>
			<th>Payment fee</th>
			<td>{!!$data->payment_fee!!}</td>
		</tr>
		<tr>
			<th>Created at</th>
			<td>
				@if ($data->created_at)
				<?php $created_at = new Carbon($data->created_at); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
		</tr>
		<tr>
			<th>Updated at</th>
			<td>
				@if ($data->updated_at)
				<?php $created_at = new Carbon($data->updated_at); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
		</tr>
	</table>
</div>
@stop