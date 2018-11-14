@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminOptions')}}">Settings</a></li>
  <li class="active">View</li>
</ol>
@stop

@section('content')
<div class="col-xs-8">
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
			<th>Type</th>
			<td>{!!$data->type!!}</td>
		</tr>
		<tr>
			<th>Category</th>
			<td>{!!$data->category!!}</td>
		</tr>
		@if ($data->type == 'text')
		<tr>
			<th>Value</th>
			<td>{!!  nl2br(e($data->value)) !!} </td>
		</tr>
		@elseif ($data->type == 'asset')
		<tr>
			<th>Asset</th>
			<td><div class="sumo-asset-display" data-id="{{$data->asset}}" data-url="{{route('adminAssetsGet')}}"></div></td>
		</tr>
		@elseif ($data->type == 'bool')
		<tr>
			<th>Value</th>
			<td>
				<?php 
                  $boolCheck = ($data->value) ? 'On': 'Off'; 
                  echo $boolCheck;
                ?>
			</td>
		</tr>
		@endif
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