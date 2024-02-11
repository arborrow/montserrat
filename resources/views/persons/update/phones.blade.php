<div class="form-group">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            {{ html()->label('Primary phone:', 'primary_phone_location_id') }}
            @if ($person->primary_phone_location_type_id == 0)
                {{ html()->select('primary_phone_location_id', $primary_phones, config('polanco.location_type.home') . ":Phone")->class('form-control') }}
            @else
                {{ html()->select('primary_phone_location_id', $primary_phones, $person->primary_phone_location_type_id . ":" . $person->primary_phone_type)->class('form-control') }}
            @endIf
        </div>
    </div>
</div><div class="form-group">
    <ul role="tablist" class="nav nav-tabs">
        <li class="nav-item" role="tab">
            @if ($person->primary_phone_location_type_id == config('polanco.location_type.home') || $person->primary_phone_location_type_id == 0)
                <a class="nav-link active" data-toggle="tab" role="tab" href="#phone_home">
            @else
                <a class="nav-link" data-toggle="tab" role="tab" href="#phone_home">
            @endIf
                <i class="fa fa-home"></i>
                <label>Home</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            @if ($person->primary_phone_location_type_id == config('polanco.location_type.work'))
                <a class="nav-link active" data-toggle="tab" role="tab" href="#phone_work">
            @else
                <a class="nav-link" data-toggle="tab" role="tab" href="#phone_work">
            @endIf
                <i class="fa fa-archive"></i>
                <label>Work</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            @if ($person->primary_phone_location_type_id == config('polanco.location_type.other'))
                <a class="nav-link active" data-toggle="tab" role="tab" href="#phone_other">
            @else
                <a class="nav-link" data-toggle="tab" role="tab" href="#phone_other">
            @endIf
                <i class="fa fa-cog"></i>
                <label>Other</label>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        @if ($person->primary_phone_location_type_id == config('polanco.location_type.home') || $person->primary_phone_location_type_id == 0)
            <div id="phone_home" class="tab-pane fade show active" role="tabpanel">
        @else
            <div id="phone_home" class="tab-pane fade" role="tabpanel">
        @endIf
            <h4>Home phone numbers</h4>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Main:', 'phone_home_phone') }}
                    {{ html()->text('phone_home_phone', $defaults['Home']['Phone'])->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Mobile:', 'phone_home_mobile') }}
                    {{ html()->text('phone_home_mobile', $defaults['Home']['Mobile'])->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Fax:', 'phone_home_fax') }}
                    {{ html()->text('phone_home_fax', $defaults['Home']['Fax'])->class('form-control') }}
                </div>
            </div>
        </div>
        @if ($person->primary_phone_location_type_id == config('polanco.location_type.work'))
            <div id="phone_work" class="tab-pane fade show active" role="tabpanel">
        @else
            <div id="phone_work" class="tab-pane fade" role="tabpanel">
        @endIf
            <h4>Work phone numbers</h4>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Main:', 'phone_work_phone') }}
                    {{ html()->text('phone_work_phone', $defaults['Work']['Phone'])->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Mobile:', 'phone_work_mobile') }}
                    {{ html()->text('phone_work_mobile', $defaults['Work']['Mobile'])->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Fax:', 'phone_work_fax') }}
                    {{ html()->text('phone_work_fax', $defaults['Work']['Fax'])->class('form-control') }}
                </div>
            </div>
        </div>
        @if ($person->primary_phone_location_type_id == config('polanco.location_type.other'))
            <div id="phone_other" class="tab-pane fade show active" role="tabpanel">
        @else
            <div id="phone_other" class="tab-pane fade" role="tabpanel">
        @endIf
            <h4>Other phone numbers</h4>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Main:', 'phone_other_phone') }}
                    {{ html()->text('phone_other_phone', $defaults['Other']['Phone'])->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Mobile:', 'phone_other_mobile') }}
                    {{ html()->text('phone_other_mobile', $defaults['Other']['Mobile'])->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Fax:', 'phone_other_fax') }}
                    {{ html()->text('phone_other_fax', $defaults['Other']['Fax'])->class('form-control') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group form-check">
    {{ html()->checkbox('do_not_phone', $person->do_not_phone, 1)->class('form-check-input')->id('do_not_phone') }}
    {{ html()->label('Do not call', 'do_not_phone')->class('form-check-label')->id('do_not_phone') }}
</div>
<div class="form-group form-check">
    {{ html()->checkbox('do_not_sms', $person->do_not_sms, 1)->class('form-check-input')->id('do_not_sms') }}
    {{ html()->label('Do not text', 'do_not_sms')->class('form-check-label')->id('do_not_sms') }}
</div>
