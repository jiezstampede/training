@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li class="active">Articles</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> Table
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminArticles')}}"><i class="fa fa-eye"></i> Show All</a>
        <a class="btn-transparent btn-sm" href="{{route('adminArticlesCreate')}}"><i class="fa fa-plus-circle"></i> Create</a>
        <a class="btn-transparent btn-sm" href="#" data-toggle="modal" data-target="#delete-modal"><i class="fa fa-minus-circle"></i> Delete</a>
      </div>
    </div>
    <div class="filters">
      {!! Form::open(['route'=>'adminArticles', 'method' => 'get']) !!}
      <label>
        Search: {!! Form::text('name', $keyword, ['class'=>'form-control input-sm', 'placeholder'=>'']) !!}
        <button><i class="fa fa-search"></i></button>
      </label>
      {!! Form::close() !!}
    </div>
    @if (count($data) > 0)
    <div class="table-responsive">
      {!! Form::open(['route'=>'adminArticlesDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th width="30px">
              <label>
                <input type="checkbox" name="delete-all" class="toggle-delete-all">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </th>
            <th width="30px"><i class="fa fa-star " aria-hidden="true"  data-toggle="tooltip" title="Featured" ></i></th>
            <th>Name</th>
            <th>Blurb</th>
            <th>Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $d)
          <tr>
            <td>
              <label>
                <input type="checkbox" name="ids[]" value="{{$d->id}}">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </td>
            <td>
              {!! $boolCheck = (@$d->featured) ? '<i class="fa fa-star" aria-hidden="true"></i>': '<i class="fa fa-star" aria-hidden="true"></i>' !!}
            </td> 
            <td>{{$d->name}}</td>
            <td>{{$d->blurb}}</td>
            <td>
              <?php $articleDate = new Carbon($d->date); ?>
              {{$articleDate->toFormattedDateString()}}
            </td>
            <td width="110px" class="text-center">
              <a href="{{route('adminArticlesEdit', [$d->id])}}" class="btn btn-primary btn-xs">EDIT</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {!! Form::close() !!}
      @if ($pagination)
      <div class="pagination-links text-right">
        {!! $pagination !!}
      </div>
      @endif
    </div>
    @else
    <div class="empty text-center">
      No results found
    </div>
    @endif
  </div>
</div>
@stop