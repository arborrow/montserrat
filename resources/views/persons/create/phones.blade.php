<div class="form-group">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            {{ html()->label('Primary phone:', 'primary_phone_location_id') }}
            {{ html()->select('primary_phone_location_id', $primary_phones, config('polanco.location_type.home') . ":Phone")->class('form-control') }}
        </div>
    </div>
</div><div class="form-group">
    <ul role="tablist" class="nav nav-tabs">
        <li class="nav-item" role="tab">
                <a class="nav-link active" data-toggle="tab" role="tab" href="#phone_home">
                <i class="fa fa-home"></i>
                <label>Home</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
                <a class="nav-link" data-toggle="tab" role="tab" href="#phone_work">
                <i class="fa fa-archive"></i>
                <label>Work</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
                <a class="nav-link" data-toggle="tab" role="tab" href="#phone_other">
                <i class="fa fa-cog"></i>
                <label>Other</label>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="phone_home" class="tab-pane fade show active" role="tabpanel">
            <h4>Home phone numbers</h4>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Main:', 'phone_home_phone') }}
                    {{ html()->text('phone_home_phone')->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Mobile:', 'phone_home_mobile') }}
                    {{ html()->text('phone_home_mobile')->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Fax:', 'phone_home_fax') }}
                    {{ html()->text('phone_home_fax')->class('form-control') }}
                </div>
            </div>
        </div>
        <div id="phone_work" class="tab-pane fade" role="tabpanel">
            <h4>Work phone numbers</h4>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Main:', 'phone_work_phone') }}
                    {{ html()->text('phone_work_phone')->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Mobile:', 'phone_work_mobile') }}
                    {{ html()->text('phone_work_mobile')->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Fax:', 'phone_work_fax') }}
                    {{ html()->text('phone_work_fax')->class('form-control') }}
                </div>
            </div>
        </div>
        <div id="phone_other" class="tab-pane fade" role="tabpanel">
            <h4>Other phone numbers</h4>

            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Main:', 'phone_other_phone') }}
                    {{ html()->text('phone_other_phone')->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Mobile:', 'phone_other_mobile') }}
                    {{ html()->text('phone_other_mobile')->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Fax:', 'phone_other_fax') }}
                    {{ html()->text('phone_other_fax')->class('form-control') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group form-check">
    {{ html()->checkbox('do_not_phone', 0, 1)->class('form-check-input')->id('do_not_phone') }}
    {{ html()->label('Do not call', 'do_not_phone')->class('form-check-label')->id('do_not_phone') }}
</div>
<div class="form-group form-check">
    {{ html()->checkbox('do_not_sms', 0, 1)->class('form-check-input')->id('do_not_sms') }}
    {{ html()->label('Do not text', 'do_not_sms')->class('form-check-label')->id('do_not_sms') }}
</div>
