@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
    <li><a href="{{route('adminTransactions')}}">Transactions</a></li>
    <li class="active">Upload from cSV</li>
</ol>
@stop

@section('content')
<div class="col-md-12">
    <div class="card">
        {!! Form::open(['route'=>'adminTransactionUploadCSVSave', 'method' => 'post', 'class'=>'form form-parsley form-delete']) !!}
        <div class="card-header row">
            <div class="col-sm-6">
                <h4 class="card-title"> Transactions | Review uploaded CSV <br><small>{{ count($transactions) }} Transactions Found</small></h4>
                <p><small>* All transactions with order items not in database will <b>not be imported.</b> </small></p>
            </div>
            <div class="col-sm-6">
                <div class="form-group pull-right">
                    <a href="{{route('adminTransactions')}}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (count($transactions) > 0)
            <input type="hidden" name="transactions" value="{{ json_encode($transactions) }}">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-primary">
                        <th>Date</th>
                        <th>Number</th>
                        <th>Type</th>
                        <th>Fee Name</th>
                        <th>Details</th>
                        <th>Seller SKU</th>
                        <th>Lazada SKU</th>
                        <th>Amount</th>
                        <th>Vat</th>
                        <th>WHT</th>
                        <th>PAID STATUS</th>
                        <th>Order Number</th>
                        <th>Order Item No.</th>
                        <th>Order Item Status</th>
                        <th>Shipping Provider</th>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $tr)
                        <tr>
                            <td>{{$tr['date']}}</td>
                            <td>{{$tr['number']}}</td>
                            <td>{{$tr['type']}}</td>
                            <td>{{$tr['fee_name']}}</td>
                            <td>{{$tr['details']}}</td>
                            <td>{{$tr['seller_sku']}}</td>
                            <td>{{$tr['laz_sku']}}</td>
                            <td>
                                <?php
                                $amountClass = 'text-success';
                                if ($tr['amount'] <= 0) $amountClass = 'text-danger';
                                ?>
                                <span class="{{$amountClass}}">{{$tr['amount']}}</span>
                            </td>
                            <td>{{$tr['vat']}}</td>
                            <td>{{$tr['wht']}}</td>
                            <td>
                                <?php
                                $paidClass = 'text-danger';
                                if ($tr['paid_status'] == 'Paid') $paidClass = 'text-success';
                                ?>
                                <span class="{{$paidClass}}">{{$tr['paid_status']}}</span>
                            </td>
                            <td>
                                {{$tr['order_number']}}

                            </td>
                            <td>
                                @if (!$tr['exists'])
                                <span class="text-danger">{{$tr['order_item']}}</span>
                                <br><small class="text-danger"><strong>Order item not in database</strong></small>
                                @else
                                {{$tr['order_item']}}
                                @endif
                            </td>
                            <td>
                                <?php
                                $deliveryClass = 'text-danger';
                                if ($tr['order_item_status'] == 'Delivered') $deliveryClass = 'text-success';
                                ?>
                                <span class="{{$deliveryClass}}">{{$tr['order_item_status']}}</span>
                            </td>
                            <td>{{$tr['shipping_provider']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p>No results found</p>
            @endif
        </div>
        @if (count($transactions) > 0)
        <div class="card-footer row">
            <div class="col-sm-6">
                <h4 class="card-title"><small>{{ count($transactions) }} Transactions Found</small></h4>
            </div>
            <div class="col-sm-6">
                <div class="form-group pull-right">
                    <a href="{{route('adminTransactions')}}" class="btn btn-default">Cancel</a>
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