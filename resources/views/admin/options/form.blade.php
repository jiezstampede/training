<div class="options-form">
	<div class="form-group">
	  <label for="name">Name</label>
	  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name']) !!}
	</div>
	@if (isset($data))
	<div class="form-group">
	  <label for="slug">Slug</label>
	  {!! Form::text('slug', null, ['class'=>'form-control', 'id'=>'slug', 'placeholder'=>'Slug', 'readonly']) !!}
	</div>
	@endif
	<div class="form-group">
	  <label for="category">Category</label>
	  @if (isset($data))
	  {!! Form::select('category', ['general' => 'general', 'email' => 'email',  'site' => 'site','admin'=>'admin'], null, ['id'=>'category', 'class'=>'select2 form-control','disabled'=>'disabled']) !!}
	  @else 
	  {!! Form::select('category', ['general' => 'general', 'email' => 'email',  'site' => 'site','admin'=>'admin'], null, ['id'=>'category', 'class'=>'form-control']) !!}
	  @endif
	</div>
	<div class="form-group">
	  <label for="type">Type</label>
	  @if (isset($data))
	  {!! Form::select('type', ['text' => 'text', 'asset' => 'asset',  'bool' => 'bool'], null, ['id'=>'option-type', 'class'=>'select2 form-control','disabled'=>'disabled']) !!}
	  @else 
	  {!! Form::select('type', ['text' => 'text', 'asset' => 'asset',  'bool' => 'bool'], null, ['id'=>'option-type', 'class'=>'form-control']) !!}
	  @endif
	</div>
	<div class="form-group option-type option-type-bool hide">
	  <label for="value">On/ Off</label>
	  <br />
	 <?php $boolCheck = (@$data->value) ? ' disabled="disabled" ': 'checked=checked'; ?>
     {!! Form::checkbox('bool', '0', @$data->value , ['hidden',$boolCheck]) !!}
     {!! Form::checkbox('bool', '1', @$data->value , ['data-toggle'=>'toggle','data-size'=>'small','class'=>'form-control ', 'id'=>'featured','data-onstyle'=>'warning','data-on'=>"<i class='fa fa-lightbulb-o'></i> On",'data-off'=>"<i class='fa fa-star-o'></i> Off "]) !!}
	</div>
	<div class="form-group option-type option-type-text hide">
	  <label for="value">Value</label>
	  {!! Form::textarea('value', null, ['class'=>'form-control', 'id'=>'value', 'placeholder'=>'Value']) !!}
	</div>
	<div class="form-group option-type option-type-asset hide sumo-asset-select">
		<label for="asset">Asset</label>
		{!! Form::hidden('asset', null, ['class'=>'sumo-asset']) !!}
	</div>
	<div class="form-group clearfix">
		<a href="{{route('adminOptions')}}" class="btn btn-default">Back</a>
<button type="submit" class="btn btn-primary pull-right">
      <i class="fa fa-check" aria-hidden="true"></i>
      Save
    </button>
  </div>
</div>