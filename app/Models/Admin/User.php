<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class User extends Model
{
    use SoftDeletes;
    use Notifiable;
    use Sortable;
    public $sortable = [
        'login',
        'email',
        'id',
    ];
    protected $fillable = [
      'name','login','email','password',
    ];
    protected $hidden = [
        'password','remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany('App\Models\Role', 'user_roles');
    }
    public function roleSortable($query, $direction)
    {
        return $query->orderBy('role', $direction);
    }

}
