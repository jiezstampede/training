@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">

  <li><a href="{{route('adminActivities')}}">Activities</a></li>
  <li class="active">View</li>
</ol>
@stop

@section('content')
<div class="col-md-8">
    <table class='table table-striped table-bordered table-view'>
        <tr>
            <th>Id</th>
            <td>{!!$data->id!!}</td>
        </tr>       <tr>
            <th>Reference</th>
            <td>{!!$data->identifier_value!!}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{!!$data->user->name!!}</td>
        </tr>
        <tr>
            <th>Created at</th>
            <td>
                @if ($data->created_at)
                <?php $created_at = new Carbon($data->created_at); ?>
                {{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
                @endif
            </td>
        </tr>
        <tr>
            <th>Updated at</th>
            <td>
                @if ($data->updated_at)
                <?php $created_at = new Carbon($data->updated_at); ?>
                {{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
                @endif
            </td>
        </tr>
        <tr>
            <th>Details</th>
            <td>
                @if ($data->value_from)
                    <?php $from = json_decode($data->value_from,true); ?>
                    <?php $keys = array_keys($from); ?>
                @endif
                @if($data->value_to)
                    <?php $to = json_decode($data->value_to,true); ?>
                    <?php $tkeys = array_keys($to); ?>
                    @if(isset($keys))
                        <?php $keys = array_unique(array_merge($keys,$tkeys)); ?>
                    @else
                        <?php $keys = $tkeys ?>
                    @endif
                @endif
                <table  style="width:100%">
                    <thead>
                        <th style="width:33%">Fields</th>
                        <th style="width:33%">Before</th>
                        <th style="width:33%">After</th>
                    </thead>
                    <tbody>
                    @foreach($keys as $key)
                        <tr>
                            <td style="width:33%">
                                {{$key}}
                            </td>
                            <td style="width:33%">
                                @if($data->value_from && array_key_exists($key,$from))
                                    @if(is_array($from[$key]))
                                        @foreach($from[$key] as $k => $f)
                                        {!!$k!!} : {!!$f!!}<br>
                                        @endforeach
                                    @else
                                        {!!$from[$key]!!}
                                    @endif
                                @endif
                            </td>
                            <td style="width:33%;{{ (($data->value_to && $data->value_from ) && (!array_key_exists($key,$from) || ($from[$key] != $to[$key] )) ) ? 'background-color:yellow':'' }}">
                                @if($data->value_to  && array_key_exists($key,$to))
                                    @if(is_array($to[$key]))
                                        @foreach($to[$key] as $k => $t)
                                        {!!$k!!} : {!!$t!!}<br>
                                        @endforeach
                                    @else
                                        {!!$to[$key]!!}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
<div class="text-right">

<a href='{{route("adminActivities")}}' class='btn btn-primary'>Back</a>
</div>
</div>
@stop
