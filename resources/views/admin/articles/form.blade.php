<div class="row">
  <div class="form-group col-sm-9">
    <label for="name">Name</label>
    {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
  </div>
  
  <div class="form-group col-sm-3">
   <label for="featured"> &nbsp;</label>
   <br />
   <?php $boolCheck = (@$data->featured) ? 'disabled="disabled"': ''; ?>
     {!! Form::checkbox('featured', '0', null , ['hidden',$boolCheck]) !!}
    {!! Form::checkbox('featured', '1', null , ['data-toggle'=>'toggle','data-size'=>'small','class'=>'form-control ', 'id'=>'featured','data-onstyle'=>'warning','data-on'=>"<i class='fa fa-star'></i> Featured",'data-off'=>"<i class='fa fa-star-o'></i> Unfeatured "]) !!}
  </div>
</div>
@if (isset($data))
<div class="form-group">
  <label for="slug">Slug</label>
  {!! Form::text('slug', null, ['class'=>'form-control', 'id'=>'slug', 'placeholder'=>'Slug', 'readonly']) !!}
</div>
@endif
<div class="form-group">
  <label for="blurb">Blurb</label>
  {!! Form::text('blurb', null, ['class'=>'form-control', 'id'=>'blurb', 'placeholder'=>'Blurb']) !!}
</div>
<div class="form-group">
  <label for="date">Date</label>
  {!! Form::text('date', null, ['class'=>'form-control sumodate', 'id'=>'date', 'placeholder'=>'Date', 'required']) !!}
</div>

<div class="form-group">
  <label for="published">Published</label>
  {!! Form::select('published', ['draft' => 'draft', 'published' => 'published'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group">
  <label for="content">Content</label>
  {!! Form::textarea('content', null, ['class'=>'form-control redactor', 'id'=>'content', 'placeholder'=>'Content', 'required', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group sumo-asset-select" data-crop-url="{{route('adminArticlesCropUrl')}}">
  <label for="image">Image</label>
  {!! Form::hidden('image', null, ['class'=>'sumo-asset', 'data-id'=>@$data->id, 'data-thumbnail'=>'image_thumbnail']) !!}
</div>
<div class="form-group">
  <label for="author">Author</label>
  {!! Form::text('author', null, ['class'=>'form-control', 'id'=>'author', 'placeholder'=>'Author']) !!}
</div>
<div class="form-group">
  <label for="name">Tags</label>
  {!! Form::select('tags[]', @$tag_list, null, ['class'=>'select2 sumo-asset-tagger select2-allow-creation', 'id'=>'tags','multiple']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminArticles')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>