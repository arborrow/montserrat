{{ html()->form('POST', route('destroy-activity'))->class('mb-0')->open() }}
    {{ html()->hidden('_method', 'DELETE') }}
    {{ html()->button('<i class="fa fa-fw fa-eraser" aria-hidden="true"></i>' . trans('LaravelLogger::laravel-logger.dashboardCleared.menu.deleteAll'))->type('button')->class('text-danger dropdown-item')->data('toggle', 'modal')->data('target', '#confirmDelete')->data('title', trans('LaravelLogger::laravel-logger.modals.deleteLog.title'))->data('message', trans('LaravelLogger::laravel-logger.modals.deleteLog.message')) }}
{{ html()->form()->close() }}
