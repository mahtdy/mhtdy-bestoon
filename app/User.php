<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_activate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function hasExpiry()
    {
        $trans = Transaction::where('user_id', auth()->user()->id)->first();
        if ($trans !== null) {
            $end_date = $trans->end_date;
            $now = Carbon::now()->format('Y-m-d h:m:s');
            if ($end_date !== null && $end_date <= $now) {
                return false;
            } else {
                return $trans;
            }
        } else {
            return false;
        }

    }
}
