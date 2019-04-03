@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
    <li><a href="{{route('adminUsers')}}">Users</a></li>
    <li class="active">Create</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
    <div class="card">
        <div class="card-header">
            <h4>Create User </h4>
        </div>
        <div class="card-body">
            {!! Form::open(['route'=>'adminUsersStore', 'class'=>'form form-parsley']) !!}
            @include('admin.users.form')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop 