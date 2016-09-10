<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $alert_to
 * @property \Illuminate\Support\Collection $accounts
 * @property \Illuminate\Support\Collection $feeds
 * @property \Illuminate\Support\Collection $snapshots
 */
class Board extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'alert_to'
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
