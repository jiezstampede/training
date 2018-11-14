<!DOCTYPE html>
<html>
	<head>
		<title>Admin Login</title>
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
		{!! Html::style('css/admin-plugins.css') !!}
		{!! Html::style('css/paper-dashboard.css') !!}
	</head>

	<body class="login-page" style="height: 100vh">
		<div class="wrapper wrapper-full-page ">
			<div class="full-page section-image" filter-color="black" data-image="{{ asset('img/bg/fabio-mangione.jpg') }}">
				<!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
				<div class="content">
					@yield('content')
				</div>
			</div>
		</div>
		{!! Html::script('js/plugins.js') !!}
		<script>
			$(document).ready(function () {
				demo.checkFullPageBackgroundImage();
				@if ($error = $errors->first('message'))
					demo.showNotification('top','right', '{{ $error }}', 'danger');
				@endif
				@if (session('status'))
					demo.showNotification('top', 'right', '{{ session("status") }}', 'success');
				@endif
				@if (session('errorToken'))
					demo.showNotification('top', 'right', '{{ session("errorToken") }}', 'danger');
				@endif
			});
		</script>
	</body>
</html>