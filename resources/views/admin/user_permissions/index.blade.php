@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li class="{{($parent_id==0)?'active':''}}"><a href="{{route('adminUserPermissions', [0])}}">Functions</a></li>
  @foreach($permission_parents as $p)
  <li class="{{($parent_id==$p->id)?'active':''}}"><a href="{{route('adminUserPermissions', [$p->id])}}">{{ $p->name }}</a></li>
  @endforeach
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      @if($parent_id > 0)
      <i class="fa fa-table"></i> Sub Functions</i></b>
      @else
      <i class="fa fa-table"></i> User Functions
      @endif

      -  @if($parent_id > 0)
          <i><b>"{{ $parent_title }}" Level</b></i>
          @else
          <i>"Root" Level</i>
          @endif
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminUserPermissionsCreate', [$parent_id])}}"><i class="fa fa-plus-circle"></i> Add</a>
        <a class="btn-transparent btn-sm" href="#" data-toggle="modal" data-target="#delete-modal"><i class="fa fa-minus-circle"></i> Delete</a>
      </div>
    </div>
    <div class="">
      <div class="table row">
        <div class="col-sm-6">

        </div>
      </div>
    </div>
    @if (count($permissions) > 0)
    <div class="table-responsive">
      {!! Form::open(['route'=>'adminUserPermissionsDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
      <input type="hidden" name="category" value="{{$parent_id}}">
      <table class="table table-bordered table-hover table-striped" id="categoryTable">
        <tbody id="sortableCategory">
          @foreach ($permissions as $c)
          <tr id="{{$c->id}}">
            <td width="30px"><i class="fa fa-th-large sortable-icon" aria-hidden="true"></i></td>
            <td style="width: 30px;">
              <label>
                <input type="checkbox" name="ids[]" value="{{$c->id}}">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </td>
            <td><a href="{{route('adminUserPermissions', [$c->id])}}">{{$c->name}}</a></td>
            <td width="50px" class="text-center">
              <a href="{{route('adminUserPermissionsEdit', [$c->id])}}" class="btn btn-primary btn-xs">Edit</a>
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
<div class="col-sm-8">
  @yield('product-column')
</div>
@stop

@section('added-scripts')
  <script>
    var categoryTable = $('#categoryTable');
    var parent = '{{$parent_id}}';

    $( "#sortableCategory" ).sortable({
      update: function( event, ui ) {
        var newOrderArr = $(this).sortable('toArray');
        console.log(newOrderArr);
        reorderCategory(newOrderArr);
      }
    });
    $( "#sortableCategory" ).disableSelection();

    function reorderCategory(order)
    {
      $.ajax({
        type : 'GET',
        url: "{{route('adminUserPermissionsOrder')}}",
        data : {
          'order': order,
          'parent': parent
        },
        dataType: 'json',
        success : function(data) {
          console.log(data);
        },
        error : function(data, text, error) {

        }
      });
    }
  </script>
@stop
