@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminArticles')}}">Articles</a></li>
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
			<th>Blurb</th>
			<td>{!!$data->blurb!!}</td>
		</tr>
		<tr>
			<th>Date</th>
			<td>
				<?php $articleDate = new Carbon($data->date); ?>
				{{$articleDate->toFormattedDateString()}}
			</td>
		</tr>
		<tr>
			<th>Featured</th>
			<td>{!!$data->featured!!}</td>
		</tr>
		<tr>
			<th>Published</th>
			<td>{!!$data->published!!}</td>
		</tr>
		<tr>
			<th>Content</th>
			<td>{!!$data->content!!}</td>
		</tr>
		<tr>
			<th>Image</th>
			<td>
				<div class="sumo-asset-display" data-id="{{$data->image}}" data-url="{{route('adminAssetsGet')}}"></div>
			</td>
		</tr>
		<tr>
			<th>Author</th>
			<td>{!!$data->author!!}</td>
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
		<tr>
			<th>Deleted at</th>
			<td>
				@if ($data->deleted_at)
				<?php $created_at = new Carbon($data->deleted_at); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
		</tr>
	</table>
</div>
@stop