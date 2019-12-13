@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
    <li><a href="{{route('adminOrders')}}">Orders</a></li>
    <li class="active">Review Upload from cSV</li>
</ol>
@stop

@section('content')
<div class="col-md-12">
    <div class="card">
        {!! Form::open(['route'=>'adminOrdersUploadCSVSave', 'method' => 'post', 'class'=>'form form-parsley form-delete']) !!}
        <div class="card-header row">
            <div class="col-sm-6">
                <h4 class="card-title"> Orders | Review uploaded CSV <br><small>{{ count($orders) }} Orders Found</small></h4>
            </div>
            <div class="col-sm-6">
                <div class="form-group pull-right">
                    <a href="{{route('adminOrders')}}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (count($orders) > 0)
            <input type="hidden" name="orders" value="{{ json_encode($orders) }}">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-primary">
                        <th>Order Number</th>
                        <th>Date</th>
                        <th>Order Item No.</th>
                        <th>Details</th>
                        <th>Seller SKU</th>
                        <th>Lazada SKU</th>
                        <th>Unit Price</th>
                        <th>Order Item Status</th>
                        <th>Shipping Provider</th>
                    </thead>
                    <tbody>
                        @foreach ($orders as $orderNumber => $order)
                        @foreach($order as $item)
                        <tr>
                            <td>{{ $orderNumber }}</td>
                            <td>{{ $item['order_date'] }}</td>
                            <td>{{ $item['number'] }}</td>
                            <td>{{ $item['details'] }}</td>
                            <td>{{ $item['seller_sku'] }}</td>
                            <td>{{ $item['lazada_sku'] }}</td>
                            <td>{{ $item['unit_price'] }}</td>
                            <td>
                                <?php
                                $deliveryClass = 'text-danger';
                                if ($item['delivery_status'] == 'Delivered' || $item['delivery_status'] == 'delivered') $deliveryClass = 'text-success';
                                ?>
                                <span class="{{ $deliveryClass }}">{{ $item['delivery_status'] }}</span>

                            </td>
                            <td>{{ $item['shipping_provider'] }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p>No results found</p>
            @endif
        </div>
        @if (count($orders) > 0)
        <div class="card-footer row">
            <div class="col-sm-6">
                <h4 class="card-title"><small>{{ count($orders) }} Orders Found</small></h4>
            </div>
            <div class="col-sm-6">
                <div class="form-group pull-right">
                    <a href="{{route('adminOrders')}}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
        @endif
        {!! Form::close() !!}
    </div>
</div>
@stop