@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminPartnerSocials')}}">Partner Socials</a></li>
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
			<th>Partner id</th>
			<td>{!!$data->partner_id!!}</td>
		</tr>
		<tr>
			<th>Name</th>
			<td>{!!$data->name!!}</td>
		</tr>
		<tr>
			<th>Icon type</th>
			<td>{!!$data->icon_type!!}</td>
		</tr>
		<tr>
			<th>Icon value</th>
			<td>{!!$data->icon_value!!}</td>
		</tr>
		<tr>
			<th>Icon color</th>
			<td>{!!$data->icon_color!!}</td>
		</tr>
		<tr>
			<th>Link</th>
			<td>{!!$data->link!!}</td>
		</tr>
		<tr>
			<th>Order</th>
			<td>{!!$data->order!!}</td>
		</tr>
		<tr>
			<th>Published</th>
			<td>{!!$data->published!!}</td>
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