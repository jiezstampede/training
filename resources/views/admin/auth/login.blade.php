@extends('layouts.admin-auth')

@section('content')
<div class="container" style="margin-top: 0">
	<div class="col-lg-4 col-md-6 ml-auto mr-auto">
		{!! Form::open(['route'=>'adminAuthenticate', 'class'=>'form']) !!}
			<div class="card card-login">
				<div class="card-header ">
					<div class="card-header ">
						<h3 class="header text-center">Login</h3>
					</div>
				</div>
				<div class="card-body ">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="nc-icon nc-single-02"></i>
							</span>
						</div>
						<input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email...">
					</div>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="nc-icon nc-key-25"></i>
							</span>
						</div>
						<input type="password" name="password" placeholder="Password" class="form-control">
					</div>
					<br />
					<div class="form-group text-center">
						<a href="{{ url('/password/reset') }}">Forgot password?</a>
					</div>
				</div>
				<div class="card-footer ">
					<button class="btn btn-warning btn-round btn-block mb-3" type="submit">Login</button>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop