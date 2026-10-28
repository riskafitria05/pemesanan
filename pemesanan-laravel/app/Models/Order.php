<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUS = ['menunggu', 'diproses', 'selesai', 'dibatalkan'];

    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    protected $fillable = [
        'nama_pemesan', 'alamat', 'nomor_telepon',
        'metode_pembayaran', 'total_harga', 'status_order',
    ];

    public function details()
    {
        return $this->hasMany(DetailPesanan::class, 'id_order', 'id_order');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_order', 'id_order');
    }

    /** hitungTotal() */
    public function hitungTotal(): float
    {
        return (float) $this->details->sum('subtotal');
    }
}
