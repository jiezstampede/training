@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminOptions')}}">Settings</a></li>
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
  {!! Form::model($data, ['route'=>['adminOptionsUpdate', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley']) !!}
  @include('admin.options.form')
  {!! Form::close() !!}
</div>
@if(!empty($data->help))
<div class="col-sm-4">
 <div class="widget">
    <div class="header">
      <i class="fa fa-file"></i> Help
    </div>
  </div>
  <div>
    <form>
      {{$data->help}}
    </form>
  </div>
</div>
@endif
@stop