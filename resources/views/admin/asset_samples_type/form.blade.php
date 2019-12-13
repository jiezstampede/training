<div class="form-group">
  <label for="asset_id">Asset_id</label>
  {!! Form::text('asset_id', null, ['class'=>'form-control', 'id'=>'asset_id', 'placeholder'=>'Asset_id', 'required']) !!}
</div>
<div class="form-group">
  <label for="samples_type_id">Samples_type_id</label>
  {!! Form::text('samples_type_id', null, ['class'=>'form-control', 'id'=>'samples_type_id', 'placeholder'=>'Samples_type_id', 'required']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminAssetSamplesType')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>