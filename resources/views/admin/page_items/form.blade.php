<div class="form-group">
  <label for="page_id">Page_id</label>
  {!! Form::text('page_id', null, ['class'=>'form-control', 'id'=>'page_id', 'placeholder'=>'Page_id', 'required']) !!}
</div>
@if (isset($data))
<div class="form-group">
  <label for="slug">Slug</label>
  {!! Form::text('slug', null, ['class'=>'form-control', 'id'=>'slug', 'placeholder'=>'Slug','readonly']) !!}
</div>
@endif
<div class="form-group">
  <label for="title">Title</label>
  {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'placeholder'=>'Title']) !!}
</div>
<div class="form-group">
  <label for="value">Value</label>
  {!! Form::textarea('value', null, ['class'=>'form-control redactor', 'id'=>'value', 'placeholder'=>'Value', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group">
  <label for="description">Description</label>
  {!! Form::textarea('description', null, ['class'=>'form-control redactor', 'id'=>'description', 'placeholder'=>'Description', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group">
  <label for="image">Image</label>
  {!! Form::text('image', null, ['class'=>'form-control', 'id'=>'image', 'placeholder'=>'Image']) !!}
</div>
<div class="form-group">
  <label for="json_data">Json_data</label>
  {!! Form::textarea('json_data', null, ['class'=>'form-control redactor', 'id'=>'json_data', 'placeholder'=>'Json_data', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminPageItems')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>