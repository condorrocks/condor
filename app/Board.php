<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Feed::class);
    }

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class)->with('aspect');
    }
}
