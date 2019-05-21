<div class="form-group">
    <ul role="tablist" class="nav nav-tabs">
        <li class="nav-item" role="tab">
            <a class="nav-link active" data-toggle="tab" role="tab" href="#url_main">
                <i class="fa fa-home"></i>
                <label>Personal (main)</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#url_work">
                <i class="fa fa-archive"></i>
                <label>Work</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#url_facebook">
                <i class="fab fa-facebook"></i>
                <label>Facebook</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#url_instagram">
                <i class="fab fa-instagram"></i>
                <label>Instagram</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#url_linkedin">
                <i class="fab fa-linkedin"></i>
                <label>LinkedIn</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#url_twitter">
                <i class="fab fa-twitter-square"></i>
                <label>Twitter</label>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="url_main" class="tab-pane fade show active" role="tabpanel">
            <div class="row">
                <div class="col-4">
                    {!! Form::label('url_main', 'Personal (main):')  !!}
                    {!! Form::text('url_main', $defaults['Main']['url'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div id="url_work" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-4">
                    {!! Form::label('url_work', 'Work:')  !!}
                    {!! Form::text('url_work', $defaults['Work']['url'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div id="url_facebook" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-4">
                    {!! Form::label('url_facebook', 'Facebook:')  !!}
                    {!! Form::text('url_facebook', $defaults['Facebook']['url'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div id="url_google" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-4">
                    {!! Form::label('url_google', 'Google+:')  !!}
                    {!! Form::text('url_google', $defaults['Google']['url'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div id="url_instagram" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-4">
                    {!! Form::label('url_instagram', 'Instagram:')  !!}
                    {!! Form::text('url_instagram', $defaults['Instagram']['url'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div id="url_linkedin" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-4">
                    {!! Form::label('url_linkedin', 'LinkedIn:')  !!}
                    {!! Form::text('url_linkedin', $defaults['LinkedIn']['url'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div id="url_twitter" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-4">
                    {!! Form::label('url_twitter', 'Twitter:')  !!}
                    {!! Form::text('url_twitter', $defaults['Twitter']['url'], ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
