<div class="form-group">
 <label for="name">Name</label>
 {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
<div class="form-group">
 <label for="email">Email</label>
 {!! Form::email('email', null, ['class'=>'form-control', 'id'=>'email', 'placeholder'=>'Email', 'required']) !!}
</div>
<div class="form-group">
 <label for="range">CMS Access</label>
 {!! Form::select('cms', ['0' => 'No', '1' => 'Yes'], null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
 <label for="range">Type</label>
 {!! Form::select('type', ['normal' => 'Normal', 'admin' => 'Admin', 'super' => 'Super'], null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
 <label for="range">Role</label>
 {!! Form::select('user_role_id', $user_roles, null, ['class'=>'form-control select2']) !!}
</div>	
<div class="form-group clearfix">
	<a href="{{route('adminUsers')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>