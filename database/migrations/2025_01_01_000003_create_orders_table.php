<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->string('nama_pemesan');
            $table->text('alamat');
            $table->string('nomor_telepon', 20);
            $table->string('metode_pembayaran');
            $table->decimal('total_harga', 12, 2)->default(0);
            // menunggu, diproses, selesai, dibatalkan
            $table->string('status_order')->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
