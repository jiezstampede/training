@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
	<li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
	<li>Pages</li>
	<li><a href="{{route('adminPages', [$page->slug])}}">{{ $page->name }}</a></li>
	<li class="active">About</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
	{!! Form::model($data, ['route'=>['adminPagesUpdate', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley form-edit']) !!}
	<div class="card ">
		<div class="card-header ">
			<h4 class="card-title">About</h4>
		</div>
		<div class="card-body ">
			<div class="form-group">
				<label for="title">Title</label>
				{!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'placeholder'=>'Title', 'required']) !!}
			</div>
			<div class="form-group">
				<label for="content">Content</label>
				{!! Form::textarea('content', null, ['class'=>'form-control redactor', 'id'=>'content', 'placeholder'=>'Content','data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
			</div>
		</div>
		<div class="card-footer ">
			<a href="{{route('adminPages', [$page->slug])}}" class="btn btn-default btn-round">Back</a>
			<button type="submit" class="btn btn-info btn-round">Save</button>
		</div>
	</div>
	{!! Form::close() !!}
</div>

<?php $items = General::pageItems('about'); ?>
<div class="col-sm-4">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title"> Items</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th colspan="2">Details</th>
							<th class="text-right" style="width: 75px">
								<a href="{{ route('adminPagesCreateItem', [$data->slug]) }}" class="btn btn-primary btn-round btn-icon"><i class="fas fa-plus"></i></a>
							</th>
						</tr>
					</thead>
					<tbody class="sortable" sortable-data-url="{{route('adminPagesSortItem', [$data->slug])}}">
						@if (count($items) > 0)
							@foreach($items as $item)
							<tr sortable-id="general-{{$item->id}}">
								<td width="30px" style="vertical-align: middle;"><i class="fas fa-bars sortable-icon" aria-hidden="true"></i></td>
								<td width="50px">
									@if ($item->value == 'image')
									<img width="28px" src="{{ asset($item->asset->small_thumbnail) }}" alt="">
									@else
									<i class="{{ $item->value }}" style="color: #fe9937"></i>
									@endif
								</td>
								<td>
									{{ $item->title }}<br/>
									<small>{!! $item->description !!}</small>
								</td>
								<td class="text-right">
									<a href="{{ route('adminPagesEditItem', ['home-about', $item->id]) }}" class="btn btn-primary btn-round btn-icon"><i class="far fa-edit"></i></a>
									<a href="#" data-delete="{{ $item->id }}" class="btn btn-danger btn-round btn-icon"><i class="far fa-trash-alt"></i></a>
								</td>
							</tr>
							@endforeach
						@else
							<tr>
								<td colspan="3" class="text-center">No results found</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop