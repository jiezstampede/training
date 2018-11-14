<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name','required']) !!}
</div>
<div class="form-group">
  <label for="caption">Caption</label>
  {!! Form::text('caption', null, ['class'=>'form-control', 'id'=>'caption', 'placeholder'=>'Caption']) !!}
</div>
<div class="form-group">
  <label for="published">Published</label>
  {!! Form::select('published', ['draft' => 'draft', 'published' => 'published'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group sumo-asset-select" data-crop-url="{{route('adminBannersCropUrl')}}">
  <label for="image">Image</label>
  {!! Form::hidden('image', null, ['class'=>'sumo-asset', 'data-id'=>@$data->id, 'data-thumbnail'=>'image_thumbnail']) !!}
</div>
<div class="form-group">
  <label for="link">Link</label>
  {!! Form::text('link', null, ['class'=>'form-control', 'id'=>'link', 'placeholder'=>'Link']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminBanners')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>