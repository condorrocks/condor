<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'apikey', 'monitor_type_id',
    ];

    public function boards()
    {
        return $this->hasMany(App\Board::class);
    }
}
