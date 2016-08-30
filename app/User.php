<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Illuminate\Support\Collection $accounts
 * @property \Illuminate\Support\Collection $boards
 * @property \Carbon\Carbon $last_login_at
 * @property string $last_ip
 * @property \Illuminate\Support\Collection roles
 */
class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'last_login_at', 'last_ip',
    ];

    protected $with = ['accounts'];

    protected $dates = ['last_login_at'];

    public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }

    public function boards()
    {
        return $this->hasManyThrough(
            Board::class, Account::class,
            'id', 'id'
        );
    }
}
