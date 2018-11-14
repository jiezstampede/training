<div class="form-group">
  <label for="sample_id">Sample_id</label>
  {!! Form::text('sample_id', null, ['class'=>'form-control', 'id'=>'sample_id', 'placeholder'=>'Sample_id', 'required']) !!}
</div>
<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminSamplesTypes')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>