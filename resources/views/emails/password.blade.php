@extends('layouts.email-template')
@section('content')
<p>Hi <b>{{$user->name}}</b>,</p>
<p>It looks like  you requested a new password.</p>
<p>
If that sounds right, you can enter new password by clicking on the button below.
</p>
<br />
<a href="{{url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}" style="padding:10px 25px;background: #686868;color:white;text-decoration: none">
    Reset Password
</a>
 @stop