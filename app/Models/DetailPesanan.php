<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    public $timestamps = false;

    protected $table = 'detail_pesanans';
    protected $primaryKey = 'id_order_item';
    protected $fillable = ['id_order', 'id_menu', 'jumlah', 'harga_satuan', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    /** hitungSubtotal() */
    public static function hitungSubtotal(int $jumlah, float $hargaSatuan): float
    {
        return $jumlah * $hargaSatuan;
    }
}
