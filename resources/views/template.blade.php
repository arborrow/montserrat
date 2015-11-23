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
    </head>
    
    <body>
    <header>
        <div>
            <a href={{ route('welcome') }}>{!! Html::image('img/mrhlogoblack.png','Home',array('title'=>'Home','class'=>'logo')) !!}</a>
        </div>
        <nav class="navbar navbar-default" role="navigation">
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
                <li><a href={{ route('retreat.index') }}>{!! Html::image('img/retreat.png', 'Retreat',array('title'=>"Retreat")) !!}</a></li>
                <li><a href={{ route('reservation') }}>{!! Html::image('img/reservation.png', 'Reservation',array('title'=>"Reservation")) !!}</a></li>
                <li><a href={{ route('room') }}>{!! Html::image('img/room.png', 'Room',array('title'=>"Room")) !!}</a></li>
                <li><a href={{ route('housekeeping') }}>{!! Html::image('img/housekeeping.png', 'Housekeeping',array('title'=>"Housekeeping")) !!}</a></li>
                <li class="divider"></li>
                <li><a href={{ route('maintenance') }}>{!! Html::image('img/maintenance.png', 'Maintenance',array('title'=>"Maintenance")) !!}</a></li>
                <li><a href={{ route('grounds') }}>{!! Html::image('img/grounds.png', 'Grounds',array('title'=>"Grounds")) !!}</a></li>
                <li><a href={{ route('kitchen') }}>{!! Html::image('img/kitchen.png', 'Kitchen',array('title'=>"Kitchen")) !!}</a></li>
                <li class="divider"></li>
                <li><a href={{ route('donation') }}>{!! Html::image('img/donation.png', 'Donation',array('title'=>"Donation")) !!}</a></li>
                <li><a href={{ route('bookstore') }}>{!! Html::image('img/bookstore.png', 'Bookstore',array('title'=>"Bookstore")) !!}</a></li>
                <li class="divider"></li>
                <li><a href={{ route('users') }}>{!! Html::image('img/users.png', 'Users',array('title'=>"Users")) !!}</a></li>
                <li><a href={{ route('support') }}>{!! Html::image('img/support.png', 'Support',array('title'=>"Support")) !!}</a></li>
                <li><a href={{ route('about') }}>{!! Html::image('img/about.png', 'About',array('title' => 'About')) !!}</a></li>
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
    </div><script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#startdate" ).datepicker();
    $( "#enddate" ).datepicker();
  });
  </script>
    </body>
</html>
