<div class="col-xs-6 col-md-3">
    <div class="panel panel-{{ array_get($panel, 'summary.uptime.label') }}">
      <div class="panel-heading">{{ array_get($panel, 'name') }}</div>

        <!-- List group -->
        <ul class="list-group">
            @foreach(array_get($panel, 'summary.uptime.snapshots') as $snapshot)
                <li class="list-group-item">{{ array_get($snapshot, 'aspect.name') }} / {{ array_get($snapshot, 'target') }}</li>
            @endforeach
        </ul>

    </div>
</div>
