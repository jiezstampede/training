@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li class="active">Dashboard</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> <!-- Title --> Dashboard
    </div>
    <hr/>
    <div class="col-sm-8 col-sm-offset-2">
        <h2 class="text-center">{!! $quote !!}</h2>
        <h4 class="text-right">{{ $quote_by }}</h3>
        </h4>
    </div>
  </div>
</div>
@stop
