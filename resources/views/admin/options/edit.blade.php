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
    <div class="card ">
        <div class="card-header ">
            <h4 class="card-title">Edit Setting</h4>
        </div>
        <div class="card-body ">
            {!! Form::model($data, ['route'=>['adminOptionsUpdate', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley']) !!}
            @include('admin.options.form')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop 