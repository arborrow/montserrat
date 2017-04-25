
    <div class='panel-heading'><h2>Addresses</h2></div>
    <div class='panel-body'>
        {!! Form::label('do_not_mail', 'Do not mail:', ['class' => 'col-md-2'])  !!}
        {!! Form::checkbox('do_not_mail', 1, $person->do_not_mail,['class' => 'col-md-1']) !!}
    </div>
    
<ul role="tablist" class="nav nav-tabs bs-adaptive-tabs" id="addresses">
            <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab1-tab" href="#address_home"><i class="fa fa-home"></i> <label>Home</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#address_work"><i class="fa fa-archive"></i> <label>Work</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#address_other"><i class="fa fa-cog"></i> <label>Other</label></a></li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div aria-labelledby="tab1-tab" id="address_home" class="tab-pane fade in active" role="tabpanel">
                <h3>Home address</h3>
                        <div class='form-group'>
                        <div class='row'>
                            {!! Form::label('address_home_address1', 'Street 1:', ['class' => 'col-md-2'])  !!}
                            {!! Form::text('address_home_address1', $defaults['Home']['street_address'], ['class' => 'col-md-3']) !!}
                        </div>
                        <div class='row'>
                            {!! Form::label('address_home_address2', 'Street 2:', ['class' => 'col-md-2'])  !!}
                            {!! Form::text('address_home_address2', $defaults['Home']['supplemental_address_1'], ['class' => 'col-md-3']) !!}
                        </div>
                        <div class='row'>
                            {!! Form::label('address_home_city', 'City:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('address_home_city', $defaults['Home']['city'], ['class' => 'col-md-2']) !!}
                            {!! Form::label('address_home_state', 'State:', ['class' => 'col-md-1'])  !!}
                            {!! Form::select('address_home_state', $states, $defaults['Home']['state_province_id'], ['class' => 'col-md-2']) !!}
                        
                            {!! Form::label('address_home_zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('address_home_zip', $defaults['Home']['postal_code'], ['class' => 'col-md-2']) !!}
                        </div>
                        <div class='row'>
                            {!! Form::label('address_home_country', 'Country:', ['class' => 'col-md-2'])  !!}
                            {!! Form::select('address_home_country', $countries, $defaults['Home']['country_id'], ['class' => 'col-md-2']) !!}
                        </div>
                        </div>
            
            </div>
            <div aria-labelledby="tab2-tab" id="address_work" class="tab-pane" role="tabpanel">
                <h3>Work address</h3>
                    <div class='row'>
                        {!! Form::label('address_work_address1', 'Street 1:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address_work_address1', $defaults['Work']['street_address'], ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_work_address2', 'Street 2:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address_work_address2', $defaults['Work']['supplemental_address_1'], ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_work_city', 'City:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('address_work_city', $defaults['Work']['city'], ['class' => 'col-md-2']) !!}
                        {!! Form::label('address_work_state', 'State:', ['class' => 'col-md-1'])  !!}
                        {!! Form::select('address_work_state', $states, $defaults['Work']['state_province_id'], ['class' => 'col-md-2']) !!}
                        {!! Form::label('address_work_zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('address_work_zip', $defaults['Work']['postal_code'], ['class' => 'col-md-2']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_work_country', 'Country:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('address_work_country', $countries, $defaults['Work']['country_id'], ['class' => 'col-md-2']) !!}

                    </div>
            </div>
            <div aria-labelledby="tab3-tab" id="address_other" class="tab-pane" role="tabpanel">
                <h3>Other address</h3>
                    <div class='row'>
                        {!! Form::label('address_other_address1', 'Street 1:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address_other_address1', $defaults['Other']['street_address'], ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_other_address2', 'Street 2:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address_other_address2', $defaults['Other']['supplemental_address_1'], ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_other_city', 'City:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('address_other_city', $defaults['Other']['city'], ['class' => 'col-md-2']) !!}
                        {!! Form::label('address_other_state', 'State:', ['class' => 'col-md-1'])  !!}
                        {!! Form::select('address_other_state', $states, $defaults['Other']['state_province_id'], ['class' => 'col-md-2']) !!}
                        {!! Form::label('address_other_zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('address_other_zip', $defaults['Other']['postal_code'], ['class' => 'col-md-2']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_other_country', 'Country:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('address_other_country', $countries, $defaults['Other']['country_id'], ['class' => 'col-md-2']) !!}
                    </div>
        
            </div>
        </div>
