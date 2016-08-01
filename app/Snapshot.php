<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $board_id
 * @property BelongsTo|Board $board
 * @property int $aspect_id
 * @property BelongsTo|Aspect $aspect
 * @property string $hash
 * @property string $target
 * @property Carbon $timestamp
 * @property string $data
 */
class Snapshot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board_id', 'aspect_id', 'hash', 'target', 'timestamp', 'data',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['timestamp'];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function aspect()
    {
        return $this->belongsTo(Aspect::class);
    }
}
