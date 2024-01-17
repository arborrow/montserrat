{{ html()->form('POST', route('restore-activity'))->class('mb-0')->open() }}
    {{ html()->button('<i class="fa fa-fw fa-history" aria-hidden="true"></i>' . trans('LaravelLogger::laravel-logger.dashboardCleared.menu.restoreAll'))->type('button')->class('text-success dropdown-item')->data('toggle', 'modal')->data('target', '#confirmRestore')->data('title', trans('LaravelLogger::laravel-logger.modals.restoreLog.title'))->data('message', trans('LaravelLogger::laravel-logger.modals.restoreLog.message')) }}
{{ html()->form()->close() }}
