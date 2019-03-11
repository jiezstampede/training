@extends('layouts.admin')

@section('content')
<div class="col-sm-8">
	@yield('card')
</div>
<div class="col-sm-4">
	<div class="seo-url" data-url="{{route('adminPagesSeo')}}">
		@include('admin.seo.form')
	</div>
</div>
@stop