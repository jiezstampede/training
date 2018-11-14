@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li class="active">Banners</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> Table
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminBanners')}}"><i class="fa fa-eye"></i> Show All</a>
        <a class="btn-transparent btn-sm" href="{{route('adminBannersCreate')}}"><i class="fa fa-plus-circle"></i> Create</a>
        <a class="btn-transparent btn-sm" href="#" data-toggle="modal" data-target="#delete-modal"><i class="fa fa-minus-circle"></i> Delete</a>
      </div>
    </div>
    <div class="filters">
      {!! Form::open(['route'=>'adminBanners', 'method' => 'get']) !!}
      <label>
        Search: {!! Form::text('name', $keyword, ['class'=>'form-control input-sm', 'placeholder'=>'']) !!}
        <button><i class="fa fa-search"></i></button>
      </label>
      {!! Form::close() !!}
    </div>
    @if (count($data) > 0)
    <div class="table-responsive">
      {!! Form::open(['route'=>'adminBannersDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
      <table class="table table-bordered table-hover table-striped" >
        <thead>
          <tr>
            <th width="30px"><i class="fa fa-arrows" aria-hidden="true"></th>
            <th width="30px">
              <label>
                <input type="checkbox" name="delete-all" class="toggle-delete-all">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </th>
            <th>Name</th>
            <th>Image</th>
            <th>Caption</th>
            <th width="80px">Published</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="sortable" sortable-data-url="{{route('adminBannersOrder')}}">
          @foreach ($data as $d)
          <tr sortable-id="banner-{{$d->id}}" >
            <td><i class="fa fa-th-large sortable-icon" aria-hidden="true"></i></td>
            <td>
              <label>
                <input type="checkbox" name="ids[]" value="{{$d->id}}">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </td>
            <td>{{$d->name}}</td>
            <td><div class="sumo-asset-display" data-id="{{$d->image}}" data-url="{{route('adminAssetsGet')}}"></div></td>
            <!-- <td>{{$d->image_thumbnail}}</div></td> -->
            <td>{{$d->caption}}</td>
            <td>{{$d->published}}</td>
            <td width="110px" class="text-center">
              <a href="{{route('adminBannersEdit', [$d->id])}}" class="btn btn-primary btn-xs">EDIT</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {!! Form::close() !!}
    </div>
    @else
    <div class="empty text-center">
      No results found
    </div>
    @endif
  </div>
</div>
@stop