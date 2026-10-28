<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    const UPDATED_AT = null;

    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['nama', 'username', 'password', 'email'];
    protected $hidden = ['password'];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'id_admin', 'id_admin');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_admin', 'id_admin');
    }
}
