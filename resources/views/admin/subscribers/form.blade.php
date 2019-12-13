<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name']) !!}
</div>
<div class="form-group">
  <label for="email">Email</label>
  {!! Form::text('email', null, ['class'=>'form-control', 'id'=>'email', 'placeholder'=>'Email', 'required']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminSubscribers')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>