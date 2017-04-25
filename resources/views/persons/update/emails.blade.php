<div class='panel-heading'><h2>Email communications</h2></div>
<div class='panel-body'>
    {!! Form::label('do_not_email', 'Do not email:', ['class' => 'col-md-2'])  !!}
    {!! Form::checkbox('do_not_email', 1, $person->do_not_email,['class' => 'col-md-1']) !!}
</div>
        <ul role="tablist" class="nav nav-tabs bs-adaptive-tabs" id="addresses">
            <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab1-tab" href="#email_home"><i class="fa fa-home"></i> <label>Home</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#email_work"><i class="fa fa-archive"></i> <label>Work</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#email_other"><i class="fa fa-cog"></i> <label>Other</label></a></li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div aria-labelledby="tab1-tab" id="email_home" class="tab-pane fade in active" role="tabpanel">
                <h3>Home email</h3>
                
                {!! Form::label('email_home', 'Email:', ['class' => 'col-md-1'])  !!}
                {!! Form::text('email_home', $defaults['Home']['email'], ['class' => 'col-md-3']) !!}
                         
            </div>
            <div aria-labelledby="tab2-tab" id="email_work" class="tab-pane" role="tabpanel">
                <h3>Work email</h3>
                {!! Form::label('email_work', 'Email:', ['class' => 'col-md-1'])  !!}
                {!! Form::text('email_work', $defaults['Work']['email'], ['class' => 'col-md-3']) !!}
                
            </div>
            <div aria-labelledby="tab3-tab" id="email_other" class="tab-pane" role="tabpanel">
                <h3>Other email</h3>
                {!! Form::label('email_other', 'Email:', ['class' => 'col-md-1'])  !!}
                {!! Form::text('email_other', $defaults['Other']['email'], ['class' => 'col-md-3']) !!}
                
            </div>
        </div>