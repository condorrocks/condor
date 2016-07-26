<?php

namespace App\Condor\Panels;

use App\Aspect;
use App\Condor\Factors\Uptime\UptimeAggregator;
use Illuminate\Support\Collection;

class PanelBuilder
{
    private $panel;

    public function __construct($panel)
    {
        $this->panel = $panel;
    }

    public function get()
    {
        $name = $this->panel->name;

        $aspects = $this->panel->snapshots->groupBy('aspect_id');

        $summary = new Collection;
        foreach ($aspects as $aspect_id => $snapshots) {

            $aspect = Aspect::find($aspect_id)->first();

            $summary->put($aspect->name, $this->summarizeSnapshots($aspect_id, $snapshots));
        }

        return compact('name', 'summary');
    }

    protected function summarizeSnapshots($aspect_id, $snapshots)
    {
        switch ($aspect_id) {
            case 1:
                return with(new UptimeAggregator($this->panel->snapshots))->summarize()->snapshot();
                break;
            default:
                return;
                break;
        }
    }
}
