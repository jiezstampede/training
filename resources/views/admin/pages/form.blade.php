<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
@if (isset($data))
<div class="form-group">
  <label for="slug">Slug</label>
  {!! Form::text('slug', null, ['class'=>'form-control', 'id'=>'slug', 'placeholder'=>'Slug', 'readonly']) !!}
</div>
@endif
<div class="form-group">
  <label for="published">Published</label>
  {!! Form::select('published', ['draft' => 'draft', 'published' => 'published'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group">
  <label for="page_category_id">Page Categories</label>
  {!! Form::select('page_category_id', $categories,null, ['class'=>'form-control select2', 'id'=>'page_category_id', 'required']) !!}
</div>
<div class="form-group">
  <label for="content">Content</label>
  {!! Form::textarea('content', null, ['class'=>'form-control redactor', 'id'=>'content', 'placeholder'=>'Content', 'required','data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminPages')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>