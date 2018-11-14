@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li class="active">Settings</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> Table
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminOptions')}}"><i class="fa fa-eye"></i> Show All</a>
        <a class="btn-transparent btn-sm" href="{{route('adminOptionsCreate')}}"><i class="fa fa-plus-circle"></i> Create</a>
        <a class="btn-transparent btn-sm" href="#" data-toggle="modal" data-target="#delete-modal"><i class="fa fa-minus-circle"></i> Delete</a>
      </div>
    </div>
    <div class="filters">
      {!! Form::open(['route'=>'adminOptions', 'method' => 'get']) !!}
      <label>
        Search: {!! Form::text('name', null, ['class'=>'form-control input-sm', 'placeholder'=>'', 'required']) !!}
        <button><i class="fa fa-search"></i></button>
      </label>
      {!! Form::close() !!}
    </div>
     @if (count($data) > 0)
    <div class="table-responsive">
      {!! Form::open(['route'=>'adminOptionsDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
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
            <th>Name</th>
            <th>Slug</th>
            <th width="30px">Type</th>
            <th>Value</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $d)
          <tr>
            <td>
              @unless ($d->permanent)
              <label>
                <input type="checkbox" name="ids[]" value="{{$d->id}}">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
              @endunless
            </td>
            <td>{{$d->name}}</td>
            <td>{{$d->slug}}</td>
             <td class="text-center">
              @if ($d->type == 'text')
               <i class='fa fa-font' data-toggle="tooltip" data-placement="top" title="" data-original-title="Text"></i>
              @elseif ($d->type == 'asset')
                <i class='fa fa-image' data-toggle="tooltip" data-placement="top" title="" data-original-title="Asset"></i>
              @elseif ($d->type == 'bool')
                <i class='fa fa-power-off' data-toggle="tooltip" data-placement="top" title="" data-original-title="On/Off"></i>
              @endif
            </td>
            <td>
              @if ($d->type == 'text')
               {{str_limit($d->value,50)}}
              @elseif ($d->type == 'asset')
               <div class="sumo-asset-display" data-id="{{$d->asset}}" data-url="{{route('adminAssetsGet')}}"></div>
              @elseif ($d->type == 'bool')
                <?php 
                  $boolCheck = (@$d->value) ? 'On': 'Off'; 
                  echo $boolCheck;
                ?>
              @endif
            </td>
            <td width="110px" class="text-center">
              <a href="{{route('adminOptionsEdit', [$d->id])}}" class="btn btn-primary btn-xs">EDIT</a>
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