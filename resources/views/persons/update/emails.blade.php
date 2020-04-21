<div class="form-group form-check">
    {!! Form::checkbox('do_not_email', 1, $person->do_not_email,['class' => 'form-check-input', 'id' => 'do_not_email']) !!}
    {!! Form::label('do_not_email', 'Do not email', ['class' => 'form-check-label', 'id' => 'do_not_email']) !!}
</div>
<div class="form-group">
    <ul role="tablist" class="nav nav-tabs">
        <li class="nav-item" role="tab">
            <a class="nav-link active" data-toggle="tab" role="tab" href="#email_home">
                <i class="fa fa-home"></i>
                <label>Home</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#email_work">
                <i class="fa fa-archive"></i>
                <label>Work</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#email_other">
                <i class="fa fa-cog"></i>
                <label>Other</label>
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div aria-labelledby="tab1-tab" id="email_home" class="tab-pane fade show active" role="tabpanel">
            <h4>Home email</h4>
            <div class="row">
                <div class="col-12 col-md-8">
                    {!! Form::label('email_home', 'Email:') !!}
                    {!! Form::text('email_home', $defaults['Home']['email'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div aria-labelledby="tab2-tab" id="email_work" class="tab-pane fade" role="tabpanel">
            <h4>Work email</h4>
            <div class="row">
                <div class="col-12 col-md-8">
                    {!! Form::label('email_work', 'Email:') !!}
                    {!! Form::text('email_work', $defaults['Work']['email'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div aria-labelledby="tab3-tab" id="email_other" class="tab-pane fade" role="tabpanel">
            <h4>Other email</h4>
            <div class="row">
                <div class="col-12 col-md-8">
                    {!! Form::label('email_other', 'Email:') !!}
                    {!! Form::text('email_other', $defaults['Other']['email'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
