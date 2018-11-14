@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminPages')}}">Pages</a></li>
  <li class="active">Create</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-file"></i> Form
    </div>
  </div>
  {!! Form::open(['route'=>'adminPagesStore', 'class'=>'form form-parsley form-create']) !!}
  @include('admin.pages.form')
  {!! Form::close() !!}
</div>
@stop