@extends('layouts.email-template')
@section('content')
  <h3>Hi {{$user['name']}},</h3>

  <p>
  	You have been given access to the admin panel. Please use the credentials below to access the site
  </p>
 <p style="background:#ecf8ff;border:solid 2px #c7eaff;line-height:2;padding:14px">

  	<span>Account name: {{$user['email']}}</span>
  	<br />
  	<span>Password: {{$password}}</span>
  	<br />
  	<span>Link: <a href="{{URL::to('/admin')}}"> {{URL::to('/admin')}} </a></span>
  
  </p>      
 @stop