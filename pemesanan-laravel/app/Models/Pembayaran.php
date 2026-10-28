<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    public $timestamps = false;

    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_order', 'id_admin', 'jumlah_bayar',
        'tanggal_bayar', 'bukti_bayar', 'status_bayar',
    ];
    protected $casts = ['tanggal_bayar' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
