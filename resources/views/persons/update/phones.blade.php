<div class="form-group">
    <div class="row">
        <div class="col-lg-12 col-md-8">
            {!! Form::label('primary_phone_location_id', 'Primary phone:') !!}
            @if ($person->primary_phone_location_type_id == 0)
                {!! Form::select('primary_phone_location_id', $primary_phones, config('polanco.location_type.home').":Phone", ['class' => 'form-control']) !!}
            @else
                {!! Form::select('primary_phone_location_id', $primary_phones, $person->primary_phone_location_type_id.":".$person->primary_phone_type, ['class' => 'form-control']) !!}
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
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('phone_home_phone', 'Main:') !!}
                    {!! Form::text('phone_home_phone', $defaults['Home']['Phone'], ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('phone_home_mobile', 'Mobile:') !!}
                    {!! Form::text('phone_home_mobile', $defaults['Home']['Mobile'], ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('phone_home_fax', 'Fax:') !!}
                    {!! Form::text('phone_home_fax', $defaults['Home']['Fax'], ['class' => 'form-control']) !!}
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
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('phone_work_phone', 'Main:') !!}
                    {!! Form::text('phone_work_phone', $defaults['Work']['Phone'], ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('phone_work_mobile', 'Mobile:') !!}
                    {!! Form::text('phone_work_mobile', $defaults['Work']['Mobile'], ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('phone_work_fax', 'Fax:') !!}
                    {!! Form::text('phone_work_fax', $defaults['Work']['Fax'], ['class' => 'form-control']) !!}
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
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('phone_other_phone', 'Main:') !!}
                    {!! Form::text('phone_other_phone', $defaults['Other']['Phone'], ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('phone_other_mobile', 'Mobile:') !!}
                    {!! Form::text('phone_other_mobile', $defaults['Other']['Mobile'], ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('phone_other_fax', 'Fax:') !!}
                    {!! Form::text('phone_other_fax', $defaults['Other']['Fax'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group form-check">
    {!! Form::checkbox('do_not_phone', 1, $person->do_not_phone,['class' => 'form-check-input', 'id' => 'do_not_phone']) !!}
    {!! Form::label('do_not_phone', 'Do not call', ['class' => 'form-check-label', 'id' => 'do_not_phone']) !!}
</div>
<div class="form-group form-check">
    {!! Form::checkbox('do_not_sms', 1, $person->do_not_sms,['class' => 'form-check-input', 'id' => 'do_not_sms']) !!}
    {!! Form::label('do_not_sms', 'Do not text', ['class' => 'form-check-label', 'id' => 'do_not_sms']) !!}
</div>
