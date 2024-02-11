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
                <div class="col-lg-4">
                    {{ html()->label('Personal (main):', 'url_main') }}
                    {{ html()->text('url_main', $defaults['Main']['url'])->class('form-control') }}
                </div>
            </div>
        </div>
        <div id="url_work" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-lg-4">
                    {{ html()->label('Work:', 'url_work') }}
                    {{ html()->text('url_work', $defaults['Work']['url'])->class('form-control') }}
                </div>
            </div>
        </div>
        <div id="url_facebook" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-lg-4">
                    {{ html()->label('Facebook:', 'url_facebook') }}
                    {{ html()->text('url_facebook', $defaults['Facebook']['url'])->class('form-control') }}
                </div>
            </div>
        </div>
        <div id="url_instagram" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-lg-4">
                    {{ html()->label('Instagram:', 'url_instagram') }}
                    {{ html()->text('url_instagram', $defaults['Instagram']['url'])->class('form-control') }}
                </div>
            </div>
        </div>
        <div id="url_linkedin" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-lg-4">
                    {{ html()->label('LinkedIn:', 'url_linkedin') }}
                    {{ html()->text('url_linkedin', $defaults['LinkedIn']['url'])->class('form-control') }}
                </div>
            </div>
        </div>
        <div id="url_twitter" class="tab-pane fade" role="tabpanel">
            <div class="row">
                <div class="col-lg-4">
                    {{ html()->label('Twitter:', 'url_twitter') }}
                    {{ html()->text('url_twitter', $defaults['Twitter']['url'])->class('form-control') }}
                </div>
            </div>
        </div>
    </div>
</div>
