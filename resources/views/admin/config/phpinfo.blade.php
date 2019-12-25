@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>PHPInfo</h2>
            </div>
            <div>
                {!! phpinfo(); !!}
            </div>
        </div>
    </div>
</section>
@stop
