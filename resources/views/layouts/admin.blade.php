<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>ADMIN - {{ config('app.name', 'GPIB Immanuel Batam') }} @yield('title')</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
        <meta name="author" content="okler.net">
        
        {{-- <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('img/gpibimmanuelbtm.ico') }}" type="image/x-icon" /> --}}
        <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
        @include('layouts.admin.vendor-css-files')

		<!-- CSS -->		
        @include('layouts.admin.css-files')

        <!-- Javascripts -->
        @include('layouts.admin.js-top-files')
	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="/" class="logo">
						{{-- <img src="{{ asset('img/LPMI.png')}}" height="35" alt="Porto Admin" /> --}}
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					<form action="pages-search-results.html" class="search nav-form">
						<div class="input-group input-search">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
			
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
								<span class="name">{{ Auth::user()->name }}</span>
								<span class="role">administrator</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="/"><i class="fa fa-user"></i> My Profile</a>
								</li>
								<li>
                                    <a role="menuitem" tabindex="-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a>
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="{{set_nav_active('admin.home')}}">
										<a href="{{route('admin.home')}}">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>	
									<li class="{{set_nav_active('admin.activities.index')}}">
										<a href="{{route('admin.activities.index')}}">
											<i class="fa fa-building" aria-hidden="true"></i>
											<span>Data Ibadah</span>
										</a>
									</li>		
									{{-- <li class="{{set_nav_active('admin.activity_registrations.index')}}">
										<a href="{{route('admin.activity_registrations.index')}}">
											<i class="fa fa-building" aria-hidden="true"></i>
											<span>List Jemaat Pendaftar Ibadah</span>
										</a>
									</li>		 --}}
									<li class="{{set_nav_active('admin.ticket_registrations.index')}}">
										<a href="{{route('admin.ticket_registrations.index')}}">
											<i class="fa fa-building" aria-hidden="true"></i>
											<span>List Pendaftaran Ibadah</span>
										</a>
									</li>		
									<li class="{{set_nav_active('admin.users.index')}}">
										<a href="{{route('admin.users.index')}}">
											<i class="fa fa-building" aria-hidden="true"></i>
											<span>List User</span>
										</a>
									</li>					
								</ul>
                            </nav>
                        </div>
                    </div>
                </aside>
                <!-- end: sidebar -->
                @yield('content')
			</div>			
        </section>
        <!-- Vendor Javascript-->		
        @include('layouts.admin.vendor-js-files')
        <!-- Javascript-->	
        @include('layouts.admin.js-bottom-files')
    </body>
</html>