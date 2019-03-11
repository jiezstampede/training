{!! Form::model($seo, ['class'=>'form form-seo']) !!}
<div class="card ">
	<div class="card-header ">
		<h4 class="card-title">SEO</h4>
	</div>
	<div class="card-body ">
		<div class="form-group">
			<label for="name">Title</label>
			{!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'placeholder'=>'Title']) !!}
			{!! Form::hidden('seoable_id', $data->id) !!}
			{!! Form::hidden('seoable_type', get_class($data)) !!}
		</div>
		<div class="form-group">
			<label for="evaluation">Description</label>
			{!! Form::textarea('description', null, ['class'=>'form-control', 'id'=>'description', 'placeholder'=>'Description'])
			!!}
		</div>
		<div class="form-group sumo-asset-select">
			<label for="image">Image</label>
			{!! Form::hidden('image', null, ['class'=>'sumo-asset']) !!}
		</div>
	</div>
	<div class="card-footer ">
		<button type="submit" class="btn btn-info btn-round">Save</button>
	</div>
</div>
{!! Form::close() !!}
