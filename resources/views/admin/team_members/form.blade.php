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
  <label for="image">Image</label>
  {!! Form::text('image', null, ['class'=>'form-control', 'id'=>'image', 'placeholder'=>'Image', 'required']) !!}
</div>
<div class="form-group">
  <label for="background_image">Background_image</label>
  {!! Form::text('background_image', null, ['class'=>'form-control', 'id'=>'background_image', 'placeholder'=>'Background_image', 'required']) !!}
</div>
<div class="form-group">
  <label for="position">Position</label>
  {!! Form::text('position', null, ['class'=>'form-control', 'id'=>'position', 'placeholder'=>'Position']) !!}
</div>
<div class="form-group">
  <label for="description">Description</label>
  {!! Form::textarea('description', null, ['class'=>'form-control redactor', 'id'=>'description', 'placeholder'=>'Description', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group">
  <label for="published">Published</label>
  {!! Form::select('published', ['draft' => 'draft', 'published' => 'published'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminTeamMembers')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>