@if($snapshot->status == 0)
    {{ trans('alerts.status-change-up', ['target' => $snapshot->target] )}}
@endif

@if($snapshot->status != 0)
    {{ trans('alerts.status-change-down', ['target' => $snapshot->target] )}}
@endif