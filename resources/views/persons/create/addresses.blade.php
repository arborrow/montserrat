<div class="container">
<div class="row">    
    <h2>Addresses</h2>

    {!! Form::label('do_not_mail', 'Do not mail:', ['class' => 'col-md-2'])  !!}
    {!! Form::checkbox('do_not_mail', 1, 0,['class' => 'col-md-1']) !!}
</div>
    <ul role="tablist" class="nav nav-tabs bs-adaptive-tabs" id="addresses">
            <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab1-tab" href="#address_home"><i class="fa fa-home"></i> <label>Home</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#address_work"><i class="fa fa-archive"></i> <label>Work</label></a></li>
            <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#address_other"><i class="fa fa-cog"></i> <label>Other</label></a></li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div aria-labelledby="tab1-tab" id="address_home" class="tab-pane fade in active" role="tabpanel">
                <h3>Home address</h3>
                    
                        <div class='row'>
                            {!! Form::label('address_home_address1', 'Street 1:', ['class' => 'col-md-2'])  !!}
                            {!! Form::text('address_home_address1', null, ['class' => 'col-md-3']) !!}
                        </div>
                        <div class='row'>
                            {!! Form::label('address_home_address2', 'Street 2:', ['class' => 'col-md-2'])  !!}
                            {!! Form::text('address_home_address2', null, ['class' => 'col-md-3']) !!}
                        </div>
                        <div class='row'>
                            {!! Form::label('address_home_city', 'City:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('address_home_city', null, ['class' => 'col-md-2']) !!}
                            {!! Form::label('address_home_state', 'State:', ['class' => 'col-md-1'])  !!}
                            {!! Form::select('address_home_state', $states, '1042', ['class' => 'col-md-2']) !!}
                        
                            {!! Form::label('address_home_zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                            {!! Form::text('address_home_zip', null, ['class' => 'col-md-2']) !!}
                        </div>
                        <div class='row'>
                            {!! Form::label('address_home_country', 'Country:', ['class' => 'col-md-2'])  !!}
                            {!! Form::select('address_home_country', $countries, '1228', ['class' => 'col-md-2']) !!}
                        </div>
            
            </div>
            <div aria-labelledby="tab2-tab" id="address_work" class="tab-pane" role="tabpanel">
                <h3>Work address</h3>
                    <div class='row'>
                        {!! Form::label('address_work_address1', 'Street 1:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address_work_address1', null, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_work_address2', 'Street 2:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address_work_address2', null, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_work_city', 'City:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('address_work_city', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('address_work_state', 'State:', ['class' => 'col-md-1'])  !!}
                        {!! Form::select('address_work_state', $states, '1042', ['class' => 'col-md-2']) !!}
                        {!! Form::label('address_work_zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('address_work_zip', null, ['class' => 'col-md-2']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_work_country', 'Country:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('address_work_country', $countries, '1228', ['class' => 'col-md-2']) !!}

                    </div>
            </div>
            <div aria-labelledby="tab3-tab" id="address_other" class="tab-pane" role="tabpanel">
                <h3>Other address</h3>
                    <div class='row'>
                        {!! Form::label('address_other_address1', 'Street 1:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address_other_address1', null, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_other_address2', 'Street 2:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('address_other_address2', null, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_other_city', 'City:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('address_other_city', null, ['class' => 'col-md-2']) !!}
                        {!! Form::label('address_other_state', 'State:', ['class' => 'col-md-1'])  !!}
                        {!! Form::select('address_other_state', $states, '1042', ['class' => 'col-md-2']) !!}
                        {!! Form::label('address_other_zip', 'Zip:', ['class' => 'col-md-1'])  !!}
                        {!! Form::text('address_other_zip', null, ['class' => 'col-md-2']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('address_other_country', 'Country:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('address_other_country', $countries, '1228', ['class' => 'col-md-2']) !!}
                    </div>
        
            </div>
        </div>
</div>