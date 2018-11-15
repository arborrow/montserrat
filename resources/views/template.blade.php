<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Montserrat Retreat House Database</title>
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
				<img src="/images/mrhlogoblack.png" alt="Home" class="logo">
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
				<a href="{{action('SearchController@search')}}">{!! Html::image('/images/search.png', 'Advanced search',array('title'=>"Advanced search",'class' => 'btn btn-link')) !!}</a>
				{{ Form::close() }}
				@endcan
				@if (Auth::check())
				<div class="dropdown">
					<div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src={{ Auth::user()->avatar }} alt={{ Auth::user()->name }} class="rounded-circle">
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
		$(function () {

			// $("#start_date").datetimeEntry({
			// 	datetimeFormat: 'N d, Y h:M a'
			// });
			// $("#end_date").datetimeEntry({
			// 	datetimeFormat: 'N d, Y h:M a'
			// });
			$("#donation_date").datepicker();
			$("#payment_date").datepicker();
			$("#start_date_only").datepicker();
			$("#end_date_only").datepicker();
			$("#register_date").datepicker();
			$("#registration_confirm_date").datepicker();
			$("#attendance_confirm_date").datepicker();
			$("#arrived_at").datepicker();
			$("#departed_at").datepicker();
			$("#canceled_at").datepicker();
			$("#birth_date").datepicker();
			$("#deceased_date").datepicker();
			// $("#touched_at").datetimeEntry({
			// 	datetimeFormat: 'N d, Y h:M a'
			// });
			// $("#languages").select2({
			// 	placeholder: 'Choose language(s)'
			// });
			// $("#referrals").select2({
			// 	placeholder: 'Choose referral source(s)'
			// });
			// $("#directors").select2({
			// 	placeholder: 'Choose retreat director(s)'
			// });
			// $("#captains").select2({
			// 	placeholder: 'Choose captain(s)'
			// });
			// $("#groups").select2({
			// 	placeholder: 'Choose group(s)'
			// });
			// $("#roles").select2({
			// 	placeholder: 'Choose role(s)',
			// 	closeOnSelect: false
			// });
			// $("#permissions").select2({
			// 	placeholder: 'Choose permission(s)',
			// 	closeOnSelect: false
			// });
			// $("#users").select2({
			// 	placeholder: 'Choose user(s)',
			// 	closeOnSelect: false
			// });


		});
	</script>
</body>

</html>