<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function aspect()
    {
        return $this->belongsTo(Aspect::class);
    }
}
