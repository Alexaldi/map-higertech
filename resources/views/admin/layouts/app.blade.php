<!doctype html>
<html lang="en" dir="ltr">
	<head>

		<!-- META DATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Zanex – Bootstrap  Admin & Dashboard Template">
		<meta name="author" content="Spruko Technologies Private Limited">
		<meta name="keywords" content="admin, dashboard, dashboard ui, admin dashboard template, admin panel dashboard, admin panel html, admin panel html template, admin panel template, admin ui templates, administrative templates, best admin dashboard, best admin templates, bootstrap 4 admin template, bootstrap admin dashboard, bootstrap admin panel, html css admin templates, html5 admin template, premium bootstrap templates, responsive admin template, template admin bootstrap 4, themeforest html">
		
		<!-- TITLE -->
		<title>@yield('title', 'Admin | Higertech Karya Sinergi')</title>
		
		@include('admin.components.styles')	
		@stack('styles')

	</head>

	<body class="app sidebar-mini">

		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="{{ asset('admin/assets/images/loader.svg') }}" class="loader-img" alt="Loader">
		</div>
		<!-- /GLOBAL-LOADER -->

		<!-- PAGE -->
		<div class="page">
			<div class="page-main">

				<!--APP-SIDEBAR-->
				@include('admin.components.sidebar')
				<!--/APP-SIDEBAR-->
				
				<!-- Mobile Header -->
				@include('admin.components.header')
				<!-- /Mobile Header -->

                <!--app-content open-->
				<div class="app-content">
					<div class="side-app">
						@yield('content')
					</div>
				</div>
				<!-- CONTAINER END -->
            </div>

			<!-- Sidebar-right -->
			@include('admin.components.sidebar-right')
			<!--/Sidebar-right-->

			<!-- FOOTER -->
			@include('admin.components.footer')
			<!-- FOOTER END -->
		</div>

		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

		@include('admin.components.alert')

		@include('admin.components.scripts')	
		@stack('scripts')

	</body>
</html>