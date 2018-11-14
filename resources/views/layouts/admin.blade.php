<!DOCTYPE html>
<html>
	<head>
		<title>Admin</title>
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
		{!! Html::style('css/admin-plugins.css') !!}
		{!! Html::style('css/admin.css') !!}
		{!! Html::style('css/paper-dashboard.css') !!}
		{!! Html::style('css/stampede.css') !!}
	</head>
	<body>
		<div id="page-loader" class="loader hide">
			<div class="display-table">
			<div class="display-cell">
				<div class="spinner"></div>
			</div>
			</div>
		</div>
		<div class="wrapper">
			<div class="sidebar" data-color="brown" data-active-color="danger">
				<!--
			        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
			    -->
				<div class="logo">
					<a href="{{ URL::to('/admin/dashboard')}}" class="simple-text logo-mini">
						<div class="logo-image-small">
							<img src="{{ asset('img/logo-only-white.png') }}" />
						</div>
					</a>
					<a href="{{ URL::to('/admin/dashboard')}}" class="simple-text logo-normal">
						Hello Shredder
						<!-- <div class="logo-image-big">
			            <img src="../../assets/img/logo-big.png">
			          </div> -->
					</a>
				</div>
				<div class="sidebar-wrapper">
					<div class="user">
						<div class="photo">
							<img src="{{ asset('img/default-avatar.png') }}" />
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" class="collapsed">
								<span>
									{{ @General::profile()->name }}
									<b class="caret"></b>
								</span>
							</a>
							<div class="clearfix"></div>
							<div class="collapse" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="{{route('adminProfile')}}">
											<span class="sidebar-mini-icon">MP</span>
											<span class="sidebar-normal">My Profile</span>
										</a>
									</li>
									<li>
										<a href="{{route('adminLogout')}}">
											<span class="sidebar-mini-icon">L</span>
											<span class="sidebar-normal">Logout</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav">
						<li class="{{Menu::active('dashboard', @$menu)}}">
							<a href="{{route('adminDashboard')}}">
								<i class="nc-icon nc-bank"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="{{Menu::active('pages', @$menu)}}">
							<a href="{{route('adminPages')}}">
								<i class="nc-icon nc-book-bookmark"></i>
								<p>Pages</p>
							</a>
						</li>
						<li class="{{Menu::active('page_categories', @$menu)}}">
							<a href="{{route('adminPageCategories')}}">
								<i class="nc-icon nc-bookmark-2"></i>
								<p>Page Categories</p>
							</a>
						</li>
						<li class="{{Menu::active('articles', @$menu)}}">
							<a href="{{route('adminArticles')}}">
								<i class="nc-icon nc-paper"></i>
								<p>Articles</p>
							</a>
						</li>
						<li class="{{Menu::active('banners', @$menu)}}">
							<a href="{{route('adminBanners')}}">
								<i class="nc-icon nc-album-2"></i>
								<p>Banners</p>
							</a>
						</li>
						<li class="{{Menu::active('users', @$menu)}}">
							<a href="{{route('adminUsers')}}">
								<i class="nc-icon nc-single-02"></i>
								<p>Users</p>
							</a>
						</li>
						<li class="{{Menu::active('user_roles', @$menu)}}">
							<a href="{{route('adminUserRoles')}}">
								<i class="nc-icon nc-key-25"></i>
								<p>User Roles</p>
							</a>
						</li>
						<li class="{{Menu::active('user_permissions', @$menu)}}">
							<a href="{{route('adminUserPermissions',[0])}}">
								<i class="nc-icon nc-tap-01"></i>
								<p>Functions</p>
							</a>
						</li>
						<li>
							<a class="select asset-sidebar-link" data-toggle="modal" data-target="#assets-modal" href="#">
								<i class="nc-icon nc-box"></i>
								<p>Assets</p>
							</a>
						</li>
						<li class="{{Menu::active('options', @$menu)}}">
							<a data-toggle="collapse" href="#options" aria-expanded="false">
								<i class="nc-icon nc-settings"></i>
								<p>
									Settings
									<b class="caret"></b>
								</p>
							</a>
							<div class="collapse {{ Menu::active('options', @$menu) }} " id="options">
								<ul class="nav">
									<li class="{{Menu::active('options-general', @$menu)}}">
										<a href="{{route('adminOptions',['category=general'])}}">
											<span class="sidebar-mini-icon">G</span>
											<span class="sidebar-normal"> General </span>
										</a>
									</li>
									<li class="{{Menu::active('options-email', @$menu)}}">
										<a href="{{route('adminOptions',['category=email'])}}">
											<span class="sidebar-mini-icon">E</span>
											<span class="sidebar-normal"> Email Settings </span>
										</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="main-panel">
				<!-- Navbar -->
				<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
					<div class="container-fluid">
						<div class="navbar-wrapper">
							<div class="navbar-minimize">
								<button id="minimizeSidebar" class="btn btn-icon btn-round">
									<i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini"></i>
									<i class="nc-icon nc-minimal-left text-center visible-on-sidebar-regular"></i>
								</button>
							</div>
							<div class="navbar-toggle">
								<button type="button" class="navbar-toggler">
									<span class="navbar-toggler-bar bar1"></span>
									<span class="navbar-toggler-bar bar2"></span>
									<span class="navbar-toggler-bar bar3"></span>
								</button>
							</div>
						</div>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index"
						 aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-bar navbar-kebab"></span>
							<span class="navbar-toggler-bar navbar-kebab"></span>
							<span class="navbar-toggler-bar navbar-kebab"></span>
						</button>
					</div>
				</nav>
				<!-- End Navbar -->
				<main class="content">
					@yield('breadcrumbs')
					<div id="content">
					<div class="container-fluid">
						<div class="row">
						<div class="col-sm-12">
							<div class="page-header">
							<h1>{{$title}}</h1>
							</div>
						</div>
						</div>
						<div class="row">
						@yield('content')
						</div>
					</div>
					</div>
				</main>
			</div>
		</div>
		@include('admin.modals.assets')
		@include('admin.modals.delete')
		@include('admin.templates.asset_image')
		{!! Html::script('js/plugins.js') !!}
		{!! Html::script('js/admin.js') !!}
		@yield('added-scripts')
	</body>
</html>
