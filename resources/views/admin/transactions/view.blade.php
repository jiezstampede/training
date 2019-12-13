@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminTransactions')}}">Transactions</a></li>
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
			<th>Date</th>
			<td>{!!$data->date!!}</td>
		</tr>
		<tr>
			<th>Type</th>
			<td>{!!$data->type!!}</td>
		</tr>
		<tr>
			<th>Fee name</th>
			<td>{!!$data->fee_name!!}</td>
		</tr>
		<tr>
			<th>Amount</th>
			<td>{!!$data->amount!!}</td>
		</tr>
		<tr>
			<th>Vat</th>
			<td>{!!$data->vat!!}</td>
		</tr>
		<tr>
			<th>Wht</th>
			<td>{!!$data->wht!!}</td>
		</tr>
		<tr>
			<th>Paid status</th>
			<td>{!!$data->paid_status!!}</td>
		</tr>
		<tr>
			<th>Order number</th>
			<td>{!!$data->order_number!!}</td>
		</tr>
		<tr>
			<th>Order item number</th>
			<td>{!!$data->order_item_number!!}</td>
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