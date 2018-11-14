<div class="form-group">
  <label for="subject">Subject</label>
  {!! Form::text('subject', null, ['class'=>'form-control', 'id'=>'subject', 'placeholder'=>'Subject', 'required']) !!}
</div>
<div class="form-group">
  <label for="to">To</label>
  {!! Form::text('to', null, ['class'=>'form-control', 'id'=>'to', 'placeholder'=>'To', 'required']) !!}
</div>
<div class="form-group">
  <label for="cc">Cc</label>
  {!! Form::text('cc', null, ['class'=>'form-control', 'id'=>'cc', 'placeholder'=>'Cc']) !!}
</div>
<div class="form-group">
  <label for="bcc">Bcc</label>
  {!! Form::text('bcc', null, ['class'=>'form-control', 'id'=>'bcc', 'placeholder'=>'Bcc']) !!}
</div>
<div class="form-group">
  <label for="from_email">From_email</label>
  {!! Form::text('from_email', null, ['class'=>'form-control', 'id'=>'from_email', 'placeholder'=>'From_email', 'required']) !!}
</div>
<div class="form-group">
  <label for="from_name">From_name</label>
  {!! Form::text('from_name', null, ['class'=>'form-control', 'id'=>'from_name', 'placeholder'=>'From_name']) !!}
</div>
<div class="form-group">
  <label for="replyTo">ReplyTo</label>
  {!! Form::text('replyTo', null, ['class'=>'form-control', 'id'=>'replyTo', 'placeholder'=>'ReplyTo']) !!}
</div>
<div class="form-group">
  <label for="content">Content</label>
  {!! Form::textarea('content', null, ['class'=>'form-control redactor', 'id'=>'content', 'placeholder'=>'Content', 'required', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group">
  <label for="attach">Attach</label>
  {!! Form::textarea('attach', null, ['class'=>'form-control redactor', 'id'=>'attach', 'placeholder'=>'Attach', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group">
  <label for="status">Status</label>
  {!! Form::select('status', ['pending' => 'pending', 'sent' => 'sent', 'failed' => 'failed'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group">
  <label for="sent">Sent</label>
  {!! Form::text('sent', null, ['class'=>'form-control', 'id'=>'sent', 'placeholder'=>'Sent']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminEmails')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>