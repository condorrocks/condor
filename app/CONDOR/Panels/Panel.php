<?php

namespace App\Condor\Panels;

use App\Aspect;
use App\Condor\Aspects\SSLCertificate\SSLCertificateAggregator;
use App\Condor\Aspects\Uptime\UptimeAggregator;
use Illuminate\Support\Collection;

class Panel
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

        $summary = new Collection();
        foreach ($aspects as $aspect_id => $snapshots) {
            $aspect = Aspect::find($aspect_id);

            $summary->put($aspect->name, $this->summarizeSnapshots($aspect_id, $snapshots));
        }

        return compact('name', 'summary');
    }

    protected function summarizeSnapshots($aspect_id, $snapshots)
    {
        switch ($aspect_id) {
            case 1:
                return with(new UptimeAggregator($snapshots))->summarize()->snapshot();
                break;
            case 2:
                return with(new SSLCertificateAggregator($snapshots))->summarize()->snapshot();
                break;
            default:
                return;
                break;
        }
    }
}
