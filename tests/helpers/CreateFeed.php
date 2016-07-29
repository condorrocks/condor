<?php

use App\Feed;

trait CreateFeed
{
    private function createFeeds($count, $overrides = [])
    {
        return factory(Feed::class, $count)->create($overrides);
    }

    private function createFeed($overrides = [])
    {
        return factory(Feed::class)->create($overrides);
    }

    private function makeFeed()
    {
        return factory(Feed::class)->make();
    }
}
