<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    const UPDATED_AT = null;

    protected $table = 'menus';
    protected $primaryKey = 'id_menu';
    protected $fillable = ['nama_menu', 'deskripsi', 'kategori', 'harga', 'stok', 'gambar', 'id_admin'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function details()
    {
        return $this->hasMany(DetailPesanan::class, 'id_menu', 'id_menu');
    }

    /** cekStok() */
    public function cekStok(int $jumlah = 1): bool
    {
        return $this->stok >= $jumlah;
    }
}
