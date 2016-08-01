<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property BelongsToMany|Collection $boards
 * @property HasManyThrough|Collection $snapshots
 */
class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function boards()
    {
        return $this->belongstoMany(Board::class)->with('snapshots');
    }

    public function snapshots()
    {
        return $this->hasManyThrough(
            Snapshot::class, Board::class,
            'id', 'board_id'
        );
    }
}
