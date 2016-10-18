<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Collection $boards
 * @property \Illuminate\Support\Collection $snapshots
 * @property \Illuminate\Support\Collection $users
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

    public function users()
    {
        return $this->belongstoMany(User::class);
    }

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

    public function defaultUser()
    {
        return $this->users()->first();
    }
}
