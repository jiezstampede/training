@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminAssetSamplesType')}}">Asset Samples Type</a></li>
  <li class="active">View</li>
</ol>
@stop

@section('content')
<div class="col-md-8">
	<table class='table table-striped table-bordered table-view'>
		<tr>
			<th>Asset id</th>
			<td>{!!$data->asset_id!!}</td>
		</tr>
		<tr>
			<th>Samples type id</th>
			<td>{!!$data->samples_type_id!!}</td>
		</tr>
		<tr>
			<th>Order</th>
			<td>{!!$data->order!!}</td>
		</tr>
	</table>
</div>
@stop