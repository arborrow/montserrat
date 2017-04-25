<div class="container">
<h2>Websites (URLs)</h2>
<ul role="tablist" class="nav nav-tabs bs-adaptive-tabs" id="urls">
            <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab1-tab" href="#url_main"><i class="fa fa-home"></i> <label>Main</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#url_work"><i class="fa fa-archive"></i> <label>Work</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#url_facebook"><i class="fa fa-cog"></i> <label>Facebook</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab4-tab" href="#url_google"><i class="fa fa-cog"></i> <label>Google+</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab5-tab" href="#url_instagram"><i class="fa fa-cog"></i> <label>Instagram</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab6-tab" href="#url_linkedin"><i class="fa fa-cog"></i> <label>LinkedIn</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab7-tab" href="#url_twitter"><i class="fa fa-cog"></i> <label>Twitter</label></a></li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div aria-labelledby="tab1-tab" id="url_main" class="tab-pane fade in active" role="tabpanel">
                {!! Form::label('url_main', 'Main:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('url_main', null, ['class' => 'col-md-4']) !!}
            </div>
            <div aria-labelledby="tab2-tab" id="url_work" class="tab-pane" role="tabpanel">
                {!! Form::label('url_work', 'Work:', ['class' => 'col-md-2'])  !!}
                {!! Form::text('url_work', null, ['class' => 'col-md-3']) !!}
            </div>
            <div aria-labelledby="tab3-tab" id="url_facebook" class="tab-pane" role="tabpanel">
                {!! Form::label('url_facebook', 'Facebook:', ['class' => 'col-md-2'])  !!}
                {!! Form::text('url_facebook', null, ['class' => 'col-md-3']) !!}
            </div>
            <div aria-labelledby="tab4-tab" id="url_google" class="tab-pane" role="tabpanel">
                {!! Form::label('url_google', 'Google+:', ['class' => 'col-md-2'])  !!}
                {!! Form::text('url_google', null, ['class' => 'col-md-3']) !!}
            </div>
            <div aria-labelledby="tab5-tab" id="url_instagram" class="tab-pane" role="tabpanel">
                {!! Form::label('url_instagram', 'Instagram:', ['class' => 'col-md-2'])  !!}
                {!! Form::text('url_instagram', null, ['class' => 'col-md-3']) !!}
            </div>
            <div aria-labelledby="tab6-tab" id="url_linkedin" class="tab-pane" role="tabpanel">
                {!! Form::label('url_linkedin', 'LinkedIn:', ['class' => 'col-md-2'])  !!}
                {!! Form::text('url_linkedin', null, ['class' => 'col-md-3']) !!}
            </div>
            <div aria-labelledby="tab7-tab" id="url_twitter" class="tab-pane" role="tabpanel">
                {!! Form::label('url_twitter', 'Twitter:', ['class' => 'col-md-2'])  !!}
                {!! Form::text('url_twitter', null, ['class' => 'col-md-3']) !!}
            </div>
        </div>
</div>