<?php

namespace App\Condor\Panels;

use App\Aspect;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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
        foreach ($aspects as $aspectId => $snapshots) {
            $aspect = $this->getAspect($aspectId);

            $summary->put($aspect->name, $this->summarizeSnapshots($aspect, $snapshots));
        }

        return compact('name', 'summary');
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
