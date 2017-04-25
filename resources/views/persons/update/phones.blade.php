<div class='panel-heading'><h2>Phone numbers</h2></div>
<div class='panel-body'>
    {!! Form::label('do_not_phone', 'Do not call:', ['class' => 'col-md-2'])  !!}
    {!! Form::checkbox('do_not_phone', 1, $person->do_not_phone,['class' => 'col-md-1']) !!}
    {!! Form::label('do_not_sms', 'Do not text:', ['class' => 'col-md-2'])  !!}
    {!! Form::checkbox('do_not_sms', 1, $person->do_not_sms,['class' => 'col-md-1']) !!}

</div>

<ul role="tablist" class="nav nav-tabs bs-adaptive-tabs" id="addresses">
            <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab1-tab" href="#phone_home"><i class="fa fa-home"></i> <label>Home</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#phone_work"><i class="fa fa-archive"></i> <label>Work</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#phone_other"><i class="fa fa-cog"></i> <label>Other</label></a></li>
        </ul>
        <div class="tab-content" id="myTabContent">
            
            <div aria-labelledby="tab1-tab" id="phone_home" class="tab-pane fade in active" role="tabpanel">
                <h3>Home phone numbers</h3>
                {!! Form::label('phone_home_phone', 'Home:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('phone_home_phone', $defaults['Home']['Phone'], ['class' => 'col-md-2']) !!}
                        {!! Form::label('phone_home_mobile', 'Mobile:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('phone_home_mobile', $defaults['Home']['Mobile'], ['class' => 'col-md-2']) !!}
                        {!! Form::label('phone_home_fax', 'Fax:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('phone_home_fax', $defaults['Home']['Fax'], ['class' => 'col-md-2']) !!}
            </div>
            <div aria-labelledby="tab2-tab" id="phone_work" class="tab-pane" role="tabpanel">
            <h3>Work phone numbers</h3>
                
                        {!! Form::label('phone_work_phone', 'Work:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('phone_work_phone', $defaults['Work']['Phone'], ['class' => 'col-md-2']) !!}
                        {!! Form::label('phone_work_mobile', 'Mobile:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('phone_work_mobile', $defaults['Work']['Mobile'], ['class' => 'col-md-2']) !!}
                        {!! Form::label('phone_work_fax', 'Fax:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('phone_work_fax', $defaults['Work']['Fax'], ['class' => 'col-md-2']) !!}
            </div>
            <div aria-labelledby="tab3-tab" id="phone_other" class="tab-pane" role="tabpanel">
            <h3>Other phone numbers</h3>
                        {!! Form::label('phone_other_phone', 'Main:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('phone_other_phone', $defaults['Other']['Phone'], ['class' => 'col-md-2']) !!}
                    {!! Form::label('phone_other_mobile', 'Mobile:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('phone_other_mobile', $defaults['Other']['Mobile'], ['class' => 'col-md-2']) !!}
                    {!! Form::label('phone_other_fax', 'Fax:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('phone_other_fax', $defaults['Other']['Fax'], ['class' => 'col-md-2']) !!}

            </div>
        </div>
