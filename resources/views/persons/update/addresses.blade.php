<div class="form-group">
    <div class="row">
        <div class="col-12 col-md-8">
            {!! Form::label('primary_address', 'Primary address:') !!}
            {!! Form::select('primary_address', $primary_address_locations, $person->primary_address_location_name, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <ul role="tablist" class="nav nav-tabs">
        <li class="nav-item" role="tab">
            <a class="nav-link active" data-toggle="tab" role="tab" href="#address_home">
                <i class="fa fa-home"></i>
                <label>Home</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#address_work">
                <i class="fa fa-archive"></i>
                <label>Work</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#address_other">
                <i class="fa fa-cog"></i>
                <label>Other</label>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="address_home" class="tab-pane fade show active" role="tabpanel">
            <h4>Home address</h4>

            <div class="row">
                <div class="col-12 col-md-8">
                    {!! Form::label("address_home_address1", "Address Line 1:") !!}
                    {!! Form::text("address_home_address1", $defaults['Home']['street_address'], ["class" => "form-control"]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    {!! Form::label("address_home_address2", "Address Line 2:") !!}
                    {!! Form::text("address_home_address2", $defaults['Home']['supplemental_address_1'], ["class" => "form-control"]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label("address_home_city", "City:") !!}
                    {!! Form::text("address_home_city", $defaults['Home']['city'], ["class" => "form-control"]) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label("address_home_state", "State:") !!}
                    {!! Form::select("address_home_state", $states, $defaults['Home']['state_province_id'], ["class" => "form-control"]) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label("address_home_zip", "Zip:") !!}
                    {!! Form::text("address_home_zip", $defaults['Home']['postal_code'], ["class" => "form-control"]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label("address_home_country", "Country:") !!}
                    {!! Form::select("address_home_country", $countries, $defaults['Home']['country_id'], ["class" => "form-control"]) !!}
                </div>
            </div>
        </div>
        <div id="address_work" class="tab-pane fade" role="tabpanel">
            <h4>Work address</h4>

            <div class="row">
                <div class="col-12 col-md-8">
                    {!! Form::label("address_work_address1", "Address Line 1:") !!}
                    {!! Form::text("address_work_address1", $defaults['Work']['street_address'], ["class" => "form-control"]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    {!! Form::label("address_work_address2", "Address Line 2:") !!}
                    {!! Form::text("address_work_address2", $defaults['Work']['supplemental_address_1'], ["class" => "form-control"]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label("address_work_city", "City:") !!}
                    {!! Form::text("address_work_city", $defaults['Work']['city'], ["class" => "form-control"]) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label("address_work_state", "State:") !!}
                    {!! Form::select("address_work_state", $states, $defaults['Work']['state_province_id'], ["class" => "form-control"]) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label("address_work_zip", "Zip:") !!}
                    {!! Form::text("address_work_zip", $defaults['Work']['postal_code'], ["class" => "form-control"]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label("address_work_country", "Country:") !!}
                    {!! Form::select("address_work_country", $countries, $defaults['Work']['country_id'], ["class" => "form-control"]) !!}
                </div>
            </div>
        </div>
        <div id="address_other" class="tab-pane fade" role="tabpanel">
            <h4>Other address</h4>

            <div class="row">
                <div class="col-12 col-md-8">
                    {!! Form::label("address_other_address1", "Address Line 1:") !!}
                    {!! Form::text("address_other_address1", $defaults['Other']['street_address'], ["class" => "form-control"]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    {!! Form::label("address_other_address2", "Address Line 2:") !!}
                    {!! Form::text("address_other_address2", $defaults['Other']['supplemental_address_1'], ["class" => "form-control"]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label("address_other_city", "City:") !!}
                    {!! Form::text("address_other_city", $defaults['Other']['city'], ["class" => "form-control"]) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label("address_other_state", "State:") !!}
                    {!! Form::select("address_other_state", $states, $defaults['Other']['state_province_id'], ["class" => "form-control"]) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label("address_other_zip", "Zip:") !!}
                    {!! Form::text("address_other_zip", $defaults['Other']['postal_code'], ["class" => "form-control"]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label("address_other_country", "Country:") !!}
                    {!! Form::select("address_other_country", $countries, $defaults['Other']['country_id'], ["class" => "form-control"]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group form-check">
    <div class="row">
        <div class="col-12 col-md-8">
            {!! Form::checkbox("do_not_mail", 1, $person->do_not_mail,["class" => "form-check-input", "id" => "do_not_mail"]) !!}
            {!! Form::label("do_not_mail", "Do not mail", ["class" => "form-check-label", "id" => "do_not_mail"]) !!}
        </div>
    </div>
</div>
