<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Montserrat Retreat House Database</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//codeorigin.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
                <link rel="stylesheet"href="//codeorigin.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//codeorigin.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>

    </head>
    
    <body>
    <header>
        <div class="col-md-10">
            <a href={{ route('welcome') }}>{!! Html::image('img/mrhlogoblack.png','Home',array('title'=>'Home','class'=>'logo')) !!}</a>
        </div>
        <div class="col-md-2">
        @if (isset(Auth::User()->avatar))
        <!-- <a href='user/'> -->
            {!! Html::image(Auth::User()->avatar, Auth::User()->name,array('title'=>Auth::User()->name)) !!}
            
        <!-- </a> -->
        
        <a href={{ route('logout') }}>{!! Html::image('img/logout.png', 'Logout',array('title'=>"Logout")) !!}</a>
         
         @else
        <a href="login/google">{!! Html::image('img/login.png', 'Login',array('title'=>"Login")) !!}</a>
         @endif
        </div>
        <div class="clearfix"> </div>
        <nav class="navbar navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a href={{ route('retreat.index') }}> {!! Html::image('img/retreat.png', 'Retreats',array('title'=>"Retreats")) !!}</a></li>
                <li><a href={{ route('person.index') }}> {!! Html::image('img/person.png', 'Persons',array('title'=>"Persons")) !!}</a></li>
                <li><a href={{ route('registration.index') }}> {!! Html::image('img/registration.png', 'Registrations',array('title'=>"Registrations")) !!}</a></li>
                <!--<li><a href={{ route('reservation') }}> {!! Html::image('img/reservation.png', 'Reservation',array('title'=>"Reservation")) !!}</a></li> -->
                <li><a href={{ route('room.index') }}> {!! Html::image('img/room.png', 'Rooms',array('title'=>"Rooms")) !!}</a></li>
                <li><a href={{ route('parish.index') }}> {!! Html::image('img/parish.png', 'Parishes',array('title'=>"Parishes")) !!}</a></li>
                <li><a href={{ route('diocese.index') }}> {!! Html::image('img/diocese.png', 'Dioceses',array('title'=>"Dioceses")) !!}</a></li>
<!--          <li><a href={{ route('housekeeping') }}> {!! Html::image('img/housekeeping.png', 'Housekeeping',array('title'=>"Housekeeping")) !!}</a></li>
                <li class="divider"></li>
                <li><a href={{ route('maintenance') }}>{!! Html::image('img/maintenance.png', 'Maintenance',array('title'=>"Maintenance")) !!}</a></li>
                <li><a href={{ route('grounds') }}>{!! Html::image('img/grounds.png', 'Grounds',array('title'=>"Grounds")) !!}</a></li>
                <li><a href={{ route('kitchen') }}>{!! Html::image('img/kitchen.png', 'Kitchen',array('title'=>"Kitchen")) !!}</a></li>
                <li class="divider"></li>
                <li><a href={{ route('donation') }}>{!! Html::image('img/donation.png', 'Donation',array('title'=>"Donation")) !!}</a></li>
                <li><a href={{ route('bookstore') }}>{!! Html::image('img/bookstore.png', 'Bookstore',array('title'=>"Bookstore")) !!}</a></li>
                <li class="divider"></li>
                <li><a href={{ route('users') }}>{!! Html::image('img/users.png', 'Users',array('title'=>"Users")) !!}</a></li>
-->           
                <li><a href={{ route('touchpoint.index') }}>{!! Html::image('img/touchpoint.png', 'Touch points',array('title'=>"Touch points")) !!}</a></li>
              
                <li><a href={{ route('support') }}>{!! Html::image('img/support.png', 'Support',array('title'=>"Support")) !!}</a></li>
                <li><a href={{ route('about') }}>{!! Html::image('img/about.png', 'About',array('title' => 'About')) !!}</a></li>
                <!-- @if (isset(Auth::User()->email))
                     <li><a href={{ route('logout') }}>{!! Html::image('img/logout.png', 'Logout',array('title' => 'Logout')) !!}</a></li>
                @else
                <li><a href='login/google'>{!! Html::image('img/login.png', 'Login',array('title' => 'Login')) !!}</a></li>
                @endif
                -->
        
            </ul>
        </div><!-- /.navbar-collapse -->
        </nav>
    </header>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @yield('content')

    <hr />
    <div class='footer'>
        <p>
            <a href='https://goo.gl/QmEUut' target='_blank'>
                600 N Shady Shores Drive<br />
                Lake Dallas, TX 75065<br />
            </a>
            (940) 321-6020<br /> 
            <a href='http://montserratretreat.org/' target='_blank'>montserratretreat.org</a>
        </p>
    </div>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script type="text/javascript">
  $(function() {
    $( "#startdate" ).datepicker();
    $( "#enddate" ).datepicker();
    $( "#register" ).datepicker();
    $( "#confirmregister" ).datepicker();
    $( "#confirmattend" ).datepicker();
    $( "#arrived_at" ).datepicker();
    $( "#departed_at" ).datepicker();
    $( "#canceled_at" ).datepicker();
    $( "#dob" ).datepicker();
    $( "#touched_at" ).datepicker();
    $( "#auto").autocomplete({
        source: "../getdata",
        minLength: 1,
        select: function( event, ui ) {
            $('#response').val(ui.item.id);
        }
    });
            
  });
  </script>
    </body>
</html>
