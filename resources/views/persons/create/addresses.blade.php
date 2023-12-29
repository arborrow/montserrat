<div class="form-group">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            {{ html()->label('Primary address:', 'primary_address_location_id') }}
            {{ html()->select('primary_address_location_id', $primary_address_locations, config('polanco.location_type.home'))->class('form-control') }}
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
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("Address Line 1:", "address_home_address1") }}
                    {{ html()->text("address_home_address1")->class("form-control") }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("Address Line 2:", "address_home_address2") }}
                    {{ html()->text("address_home_address2")->class("form-control") }}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("City:", "address_home_city") }}
                    {{ html()->text("address_home_city")->class("form-control") }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("State:", "address_home_state") }}
                    {{ html()->select("address_home_state", $states, config('polanco.state_province_id_tx'))->class("form-control") }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("Zip:", "address_home_zip") }}
                    {{ html()->text("address_home_zip")->class("form-control") }}
                </div>
                <div class="col-lg-2 col-md-3">
                    {{ html()->label("Country:", "address_home_country") }}
                    {{ html()->select("address_home_country", $countries, config('polanco.country_id_usa'))->class("form-control") }}
                </div>
            </div>
        </div>
        <div id="address_work" class="tab-pane fade" role="tabpanel">

            <h4>Work address</h4>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("Address Line 1:", "address_work_address1") }}
                    {{ html()->text("address_work_address1")->class("form-control") }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("Address Line 2:", "address_work_address2") }}
                    {{ html()->text("address_work_address2")->class("form-control") }}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("City:", "address_work_city") }}
                    {{ html()->text("address_work_city")->class("form-control") }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("State:", "address_work_state") }}
                    {{ html()->select("address_work_state", $states, 0)->class("form-control") }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("Zip:", "address_work_zip") }}
                    {{ html()->text("address_work_zip")->class("form-control") }}
                </div>
                <div class="col-lg-2 col-md-3">
                    {{ html()->label("Country:", "address_work_country") }}
                    {{ html()->select("address_work_country", $countries, config('polanco.country_id_usa'))->class("form-control") }}
                </div>
            </div>
        </div>

        <div id="address_other" class="tab-pane fade" role="tabpanel">

            <h4>Other address</h4>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("Address Line 1:", "address_other_address1") }}
                    {{ html()->text("address_other_address1")->class("form-control") }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("Address Line 2:", "address_other_address2") }}
                    {{ html()->text("address_other_address2")->class("form-control") }}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("City:", "address_other_city") }}
                    {{ html()->text("address_other_city")->class("form-control") }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("State:", "address_other_state") }}
                    {{ html()->select("address_other_state", $states, 0)->class("form-control") }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label("Zip:", "address_other_zip") }}
                    {{ html()->text("address_other_zip")->class("form-control") }}
                </div>
                <div class="col-lg-2 col-md-3">
                    {{ html()->label("Country:", "address_other_country") }}
                    {{ html()->select("address_other_country", $countries, config('polanco.country_id_usa'))->class("form-control") }}
                </div>
            </div>

        </div>
    </div>
</div>

<div class="form-group form-check">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            {{ html()->checkbox("do_not_mail", 0, 1)->class("form-check-input")->id("do_not_mail") }}
            {{ html()->label("Do not mail", "do_not_mail")->class("form-check-label")->id("do_not_mail") }}
        </div>
    </div>
</div>
