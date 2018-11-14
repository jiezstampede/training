<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
@if (isset($data))
<div class="form-group">
  <label for="slug">Slug</label>
  {!! Form::text('slug', null, ['class'=>'form-control', 'id'=>'slug', 'placeholder'=>'Slug','readonly']) !!}
</div>
@endif
<div class="form-group">
  <label for="date">Date</label>
  {!! Form::text('date', null, ['class'=>'form-control sumodate', 'id'=>'date', 'placeholder'=>'Date']) !!}
</div>
<div class="form-group">
  <label for="tinyint">Tinyint</label>
  <br />
   <?php $boolCheck = (@$data->tinyint) ? 'disabled="disabled"': ''; ?>
     {!! Form::checkbox('tinyint', '0', null , ['hidden',$boolCheck]) !!}
    {!! Form::checkbox('tinyint', '1', null , ['data-toggle'=>'toggle','data-size'=>'small','class'=>'form-control ', 'id'=>'tinyint','data-onstyle'=>'warning','data-on'=>"<i class='fa fa-star'></i> On",'data-off'=>"<i class='fa fa-star-o'></i> Off "]) !!}
</div><div class="form-group">
  <label for="integer">Integer</label>
  {!! Form::text('integer', null, ['class'=>'form-control', 'id'=>'integer', 'placeholder'=>'Integer', 'required']) !!}
</div>
<div class="form-group sumo-asset-select" data-crop-url="{{route('adminTestsCropUrl')}}">
  <label for="image">Image</label>
  {!! Form::hidden('image', null, ['class'=>'sumo-asset', 'data-id'=>@$data->id, 'data-thumbnail'=>'image_thumbnail']) !!}
</div>
<div class="form-group">
  <label for="enum">Enum</label>
  {!! Form::select('enum', ['one' => 'one', 'two' => 'two'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group">
  <label for="text">Text</label>
  {!! Form::textarea('text', null, ['class'=>'form-control redactor', 'id'=>'text', 'placeholder'=>'Text', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminTests')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>