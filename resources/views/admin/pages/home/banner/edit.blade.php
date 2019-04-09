@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
	<li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
	<li>Pages</li>
	<li><a href="{{route('adminPages', [$page->slug])}}">{{ $page->name }}</a></li>
	<li class="active">Banner</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
	{!! Form::model($data, ['route'=>['adminPagesUpdate', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley form-edit']) !!}
		<div class="card">
			<div class="card-header ">
				<h4 class="card-title">Banner</h4>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label for="title">Title</label>
					{!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'placeholder'=>'Title']) !!}
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					{!! Form::text('description', null, ['class'=>'form-control', 'id'=>'description', 'placeholder'=>'Description']) !!}
				</div>
				<div class="form-group">
					<label for="button_caption">Button Caption</label>
					{!! Form::text('button_caption', null, ['class'=>'form-control', 'id'=>'button_caption', 'placeholder'=>'Button Caption']) !!}
				</div>
				<div class="form-group">
					<label for="button_link">Button Link</label>
					{!! Form::text('button_link', null, ['class'=>'form-control', 'id'=>'button_link', 'placeholder'=>'Button Link']) !!}
				</div>
				<div class="form-group sumo-asset-select">
					<label for="image">Image</label>
					{!! Form::hidden('image', null, ['class'=>'sumo-asset']) !!}
				</div>
			</div>
			<div class="card-footer ">
				<a href="{{route('adminPages', [$page->slug])}}" class="btn btn-default btn-round">Back</a>
				<button type="submit" class="btn btn-info btn-round">Save</button>
			</div>
		</div>
	{!! Form::close() !!}
</div>
@stop