@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
	<li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
	<li>Pages</li>
	<li class="active">{{ $data->title }}</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title"> {{ $data->title }}</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Sections</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@yield('items')
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="col-sm-4">
	<div class="seo-url" data-url="{{route('adminPagesSeo')}}">
		@include('admin.seo.form')
	</div>
</div>
@stop