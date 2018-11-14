@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminUserPermissions', [0])}}">Functions</a></li>
  @foreach($permission_parents as $p)
  <li><a href="{{route('adminUserPermissions', [$p->id])}}">{{ $p->name }}</a></li>
  @endforeach
  <li class="active">Edit Function</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
  <div class="widget">
    <div class="header">
      <i class="fa fa-file"></i> Form
    </div>
  </div>
  {!! Form::model($data, ['route'=>['adminUserPermissionsUpdate', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley form-edit']) !!}
  @include('admin.user_permissions.form')
  {!! Form::close() !!}
</div>
@stop