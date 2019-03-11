<div class="card-body ">
	<div class="form-group">
		<label for="title">Title</label>
		{!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'placeholder'=>'Title', 'required']) !!}
	</div>
    <div class="form-group">
        <label for="description">Description</label>
        {!! Form::textarea('description', null, ['class'=>'form-control redactor', 'id'=>'description', 'placeholder'=>'Description','data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
    </div>
	<?php
		$icon_type = 'font-awesome';
		$fontawesome = @$data->value;
		if (@$data->value == 'image') {
			$icon_type = 'image';
			$fontawesome = '';
		}
	?>
	<div class="form-group">
		<label for="icon_type">Icon Type</label>
		{!! Form::select('icon_type', ['font-awesome' => 'font-awesome', 'image' => 'image'], $icon_type, ['class'=>'form-control select2']) !!}
	</div>
	<div class="form-group sumo-asset-select icon-image @if(@$data->value !== 'image') hide @endif">
		<label for="icon_value">
			Icon Image
			<small class="notes">(36px by 36px)</small>
		</label>
		{!! Form::hidden('icon_image', @$data->image, ['class'=>'sumo-asset']) !!}
	</div>
	<div class="form-group icon-font-awesome @if(@$data->value === 'image') hide @endif">
		<label for="icon_value">
			<div>Font Awesome Class</div>
			<small class="notes">Only free icons are available. <a href="https://fontawesome.com/">View available font awesome icons.</a></small>
		</label>
		{!! Form::text('icon_font_awesome', $fontawesome, ['class'=>'form-control', 'id'=>'icon_value', 'placeholder'=>'example: fab fa-facebook-f']) !!}
	</div>
</div>

@section('added-scripts')
@parent
<script>
	$('[name="icon_type"]').on('change', function (e) {
		if ($(this).val() == 'image') {
			$('.icon-font-awesome').addClass('hide');
			$('.icon-color').addClass('hide');
			$('.icon-image').removeClass('hide');
		} else {
			$('.icon-image').addClass('hide');
			$('.icon-font-awesome').removeClass('hide');
			$('.icon-color').removeClass('hide');
		}
	});
</script>
@stop