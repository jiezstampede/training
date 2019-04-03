@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminUserRoles')}}">User Roles</a></li>
  <li class="active">Edit</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">
        Edit User Role
      </h4>
    </div>
    <div class="card-body">
      {!! Form::model($data, ['route'=>['adminUserRolesUpdate', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley form-edit row']) !!}
      @include('admin.user_roles.form')
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop