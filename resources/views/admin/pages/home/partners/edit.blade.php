@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
	<li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
	<li>Pages</li>
	<li><a href="{{route('adminPages', [$page->slug])}}">{{ $page->name }}</a></li>
	<li class="active">Partners</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
	{!! Form::model($data, ['route'=>['adminPagesUpdate', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley form-edit']) !!}
	<div class="card ">
		<div class="card-header ">
			<h4 class="card-title">Partners</h4>
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
@stop