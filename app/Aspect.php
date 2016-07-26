<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aspect extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }
}
