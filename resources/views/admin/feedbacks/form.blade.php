<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
<div class="form-group">
  <label for="email">Email</label>
  {!! Form::text('email', null, ['class'=>'form-control', 'id'=>'email', 'placeholder'=>'Email', 'required']) !!}
</div>
<div class="form-group">
  <label for="phone">Phone</label>
  {!! Form::text('phone', null, ['class'=>'form-control', 'id'=>'phone', 'placeholder'=>'Phone', 'required']) !!}
</div>
<div class="form-group">
  <label for="subject">Subject</label>
  {!! Form::text('subject', null, ['class'=>'form-control', 'id'=>'subject', 'placeholder'=>'Subject']) !!}
</div>
<div class="form-group">
  <label for="message">Message</label>
  {!! Form::textarea('message', null, ['class'=>'form-control redactor', 'id'=>'message', 'placeholder'=>'Message', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group">
  <label for="ip">Ip</label>
  {!! Form::text('ip', null, ['class'=>'form-control', 'id'=>'ip', 'placeholder'=>'Ip', 'required']) !!}
</div>
<div class="form-group">
  <label for="sent">Sent</label>
  {!! Form::text('sent', null, ['class'=>'form-control', 'id'=>'sent', 'placeholder'=>'Sent', 'required']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminFeedbacks')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>