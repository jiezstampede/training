@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminBanners')}}">Banners</a></li>
  <li class="active">Edit</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
  <div class="widget">
    <div class="header">
      <i class="fa fa-file"></i> Form
    </div>
  </div>
  {!! Form::model($data, ['route'=>['adminBannersUpdate', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley form-edit']) !!}
  @include('admin.banners.form')
  {!! Form::close() !!}
</div>
<div class="seo-url" data-url="{{route('adminBannersSeo')}}">
  @include('admin.seo.form')
</div>
@stop