@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminUserPermissions')}}">Functions</a></li>
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
			<th>Name</th>
			<td>{!!$data->name!!}</td>
		</tr>
		<tr>
			<th>Slug</th>
			<td>{!!$data->slug!!}</td>
		</tr>
		<tr>
			<th>Description</th>
			<td>{!!$data->description!!}</td>
		</tr>
		<tr>
			<th>Parent</th>
			<td>{!!$data->parent!!}</td>
		</tr>
		<tr>
			<th>Master</th>
			<td>{!!$data->master!!}</td>
		</tr>
		<tr>
			<th>Order</th>
			<td>{!!$data->order!!}</td>
		</tr>
		<tr>
			<th>Deleted at</th>
			<td>
				@if ($data->deleted_at)
				<?php $created_at = new Carbon($data->deleted_at); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
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