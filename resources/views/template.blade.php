<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Montserrat Retreat House Database</title>
	<!-- generated from https://realfavicongenerator.net/ -->
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

	<link rel="stylesheet" type="text/css" href="{{ url(mix('dist/bundle.css')) }}">
	<script src="{{ url(mix('dist/bundle.js')) }}"></script>
	<script>
		function ConfirmDelete() {
			var x = confirm("Are you sure you want to delete?");
			if (x)
				return true;
			else
			return false;
		}
	</script>
</head>
<body>
	<div class="container pt-0">
		<nav class="navbar navbar-expand-lg navbar-light">
			<a class="navbar-brand" href={{ ( Auth::check() ) ? route('welcome') : route('home') }}>
				<img src="{{URL('/images/mrhlogoblack.png')}}" alt="Home" class="logo">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarContent">
				<ul class="navbar-nav mr-auto">
					@can('show-contact')
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Contacts
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href={{ route('person.index') }}>Persons</a>
							<a class="dropdown-item" href={{ route('parish.index') }}>Parishes</a>
							<a class="dropdown-item"  href={{ route('diocese.index') }}>Dioceses</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href={{ route('organization.index') }}>Organizations</a>
							<a class="dropdown-item" href={{ route('vendor.index') }}>Vendors</a>
						</div>
					</li>
					@endCan
					@can('show-retreat')
					<li class="nav-item">
						<a class="nav-link" href={{ route('retreat.index') }}>Events</a>
					</li>
					@endCan
					@can('show-room')
					<li class="nav-item">
						<a class="nav-link" href={{ route('rooms') }}>Rooms</a>
					</li>
					@endCan
					@can('show-donation')
					<li class="nav-item">
						<a class="nav-link" href={{ route('finance') }}>Finance</a>
					</li>
					@endCan
					@can('show-gate')
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Gate Controls
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href={{ route('gate.open') }}>Open</a>
							<a class="dropdown-item" href={{ route('gate.close') }}>Close</a>
							<div class="dropdown-divider"></div>
							<div class="dropright dropdown-submenu">
								<a class="dropdown-item dropdown-toggle" href="#" role="button" data-toggle="dropdown">Open for...</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href={{ route('gate.open', 1) }}>1 hour</a>
									<a class="dropdown-item" href={{ route('gate.open', 2) }}>2 hours</a>
									<a class="dropdown-item" href={{ route('gate.open', 3) }}>3 hours</a>
									<a class="dropdown-item" href={{ route('gate.open', 4) }}>4 hours</a>
									<a class="dropdown-item" href={{ route('gate.open', 5) }}>5 hours</a>
								</div>
							</div>
						</div>
					</li>
                    @endcan
					@can('show-admin-menu')
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Admin
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href={{ route('role.index') }}>Roles</a>
							<a class="dropdown-item" href={{ route('permission.index') }}>Permissions</a>
						</div>
					</li>
					@endCan
				</ul>
				@can('show-contact')
				{{ Form::open(['action' => ['SearchController@getuser'], 'method' => 'GET', 'class' => 'form-inline my-2 my-lg-0']) }}
				{{ Form::text('contactSearch', '', ['id' =>  'contactSearch', 'placeholder' =>  'Find contact by name','class'=>'form-control mr-sm-2'])}}
				{{ Form::hidden('response', '', array('id' =>'response')) }}
				{{ Form::submit('Find Person', array('class' => 'btn btn-outline-success my-2 my-sm-0','id'=>'btnSearch','style'=>'display:none')) }}
				<a href="{{action('SearchController@search')}}">{!! Html::image('images/search.png', 'Advanced search',array('title'=>"Advanced search",'class' => 'btn btn-link')) !!}</a>
				{{ Form::close() }}
				@endcan
				@if (Auth::check())
				<div class="dropdown">
					<div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" title="{{ Auth::user()->name }}" class="rounded-circle avatar">
					</div>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href={{ route('logout') }}>Logout</a>
					</div>
				</div>


				@else
				<a href={{ route('login') }}>
					Login
				</a>
				@endif
			</div>
		</nav>
	</div>

		@if (isset($errors) && count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		<div class="container">
			@yield('content')
			<hr/>
			<div class="footer row">
				<div class="col-12 text-center">
					<p>
						<a href='https://goo.gl/QmEUut' target='_blank'>
							600 N Shady Shores Drive<br />
							Lake Dallas, TX 75065<br />
						</a>
						(940) 321-6020<br />
						<a href='http://montserratretreat.org/' target='_blank'>montserratretreat.org</a>
					</p>
				</div>
			</div>
		</div>

	<script type="text/javascript">
	$("#contactSearch").autocomplete({
				source: "{{ url('search/autocomplete') }}",
				minLength: 3,
				autoFocus: true,
				select: function (event, ui) {
					$('#contactSearch').val(ui.item.value);
					$('#response').val(ui.item.id);
					$('#btnSearch').click();
				}
			});
			console.log($("#q"));
	</script>
</body>

</html>
