@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
	<li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
	<li>Pages</li>
	<li><a href="{{route('adminPages', ['home'])}}">Home</a></li>
	<li><a href="{{route('adminPagesEdit', ['home', 'home-about'])}}">About</a></li>
	<li class="active">Create Item</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
	{!! Form::open(['route'=>['adminPagesStoreItemFromPage', $slug, 'about'], 'class'=>'form form-parsley form-create']) !!}
		<div class="card ">
			<div class="card-header ">
				<h4 class="card-title">Create Item</h4>
			</div>
			@include('admin.pages.home.about.items.form')
			<div class="card-footer ">
				<a href="{{route('adminPagesEdit', ['about', 'home-about'])}}" class="btn btn-default btn-round">Back</a>
				<button type="submit" class="btn btn-info btn-round">Save</button>
			</div>
		</div>
	{!! Form::close() !!}
</div>
@stop