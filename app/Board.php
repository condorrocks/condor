<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property BelongsToMany|Collection $accounts
 * @property BelongsToMany|Collection $feeds
 * @property HasMany|Collection $snapshots
 */
class Board extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }

    public function feeds()
    {
        return $this->belongsToMany(Feed::class)->with('aspect');
    }

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class)->with('aspect');
    }
}
