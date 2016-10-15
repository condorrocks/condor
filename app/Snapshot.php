<?php

namespace App;

use App\Presenters\SnapshotPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * @property int $id
 * @property int $board_id
 * @property int $aspect_id
 * @property int $feed_id
 * @property \App\Board $board
 * @property \App\Aspect $aspect
 * @property \App\Feed $feed
 * @property string $hash
 * @property string $target
 * @property \Carbon\Carbon $timestamp
 * @property string $data
 * @property int $status
 * @property int $last_status
 */
class Snapshot extends Model implements HasPresenter
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board_id', 'aspect_id', 'feed_id', 'hash', 'target', 'timestamp', 'data', 'status', 'last_status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['timestamp'];

    public function getPresenterClass()
    {
        return SnapshotPresenter::class;
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function aspect()
    {
        return $this->belongsTo(Aspect::class);
    }

    /**
     * Get a value from JSON data
     * 
     * @param  string $key
     * @return mixed|null
     */
    public function data($key)
    {
        $array = json_decode($this->data, true);

        return array_get($array, $key, null);
    }
}
