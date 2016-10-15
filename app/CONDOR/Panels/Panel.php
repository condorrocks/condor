<?php

namespace App\Condor\Panels;

use App\Aspect;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Panel
{
    private $panel = null;

    private $summary = null;

    private $snapshots;

    public function __construct($panel)
    {
        $this->panel = $panel;
    }

    protected function initSummary()
    {
        $this->summary = new Collection();
    }

    protected function initSnapshots()
    {
        $this->snapshots = new Collection();
    }

    public function get()
    {
        if ($this->summary === null) {
            $this->build();
        }

        return [
            'name'      => $this->panel->name,
            'summary'   => $this->summary,
            'snapshots' => $this->snapshots,
        ];
    }

    protected function build()
    {
        $aspects = $this->panel->snapshots->groupBy('aspect_id');

        $this->initSummary();

        $this->initSnapshots();

        foreach ($aspects as $aspectId => $snapshots) {
            $aspect = $this->getAspect($aspectId);

            $this->summary->put($aspect->name, $this->summarizeSnapshots($aspect, $snapshots));

            foreach ($snapshots as $snapshot) {
                $this->snapshots->push($snapshot);
            }
        }
    }

    protected function summarizeSnapshots(Aspect $aspect, $snapshots)
    {
        $aggregatorClassName = config("aggregators.{$aspect->name}");

        return with(new $aggregatorClassName($snapshots))->getSummary();
    }

    /**
     * Get a cached instance of Aspect
     *
     * @param  int $aspectId
     *
     * @return App\Aspect|null
     */
    protected function getAspect($aspectId)
    {
        return Cache::get("aspectId:{$aspectId}", function () use ($aspectId) {
            return Aspect::find($aspectId);
        });
    }
}
