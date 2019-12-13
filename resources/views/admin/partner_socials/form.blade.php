<div class="form-group">
  <label for="partner_id">Partner_id</label>
  {!! Form::text('partner_id', null, ['class'=>'form-control', 'id'=>'partner_id', 'placeholder'=>'Partner_id', 'required']) !!}
</div>
<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
<div class="form-group">
  <label for="icon_type">Icon_type</label>
  {!! Form::select('icon_type', ['font-awesome' => 'font-awesome', 'image' => 'image'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group">
  <label for="icon_value">Icon_value</label>
  {!! Form::text('icon_value', null, ['class'=>'form-control', 'id'=>'icon_value', 'placeholder'=>'Icon_value']) !!}
</div>
<div class="form-group">
  <label for="icon_color">Icon_color</label>
  {!! Form::text('icon_color', null, ['class'=>'form-control', 'id'=>'icon_color', 'placeholder'=>'Icon_color']) !!}
</div>
<div class="form-group">
  <label for="link">Link</label>
  {!! Form::textarea('link', null, ['class'=>'form-control redactor', 'id'=>'link', 'placeholder'=>'Link', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group">
  <label for="published">Published</label>
  {!! Form::select('published', ['draft' => 'draft', 'published' => 'published'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminPartnerSocials')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>