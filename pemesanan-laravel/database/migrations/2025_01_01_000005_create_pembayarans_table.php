<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_order')->unique(); // relasi 1:1 dengan orders
            $table->unsignedBigInteger('id_admin')->nullable(); // admin yang memverifikasi
            $table->decimal('jumlah_bayar', 12, 2);
            $table->timestamp('tanggal_bayar')->nullable();
            $table->string('bukti_bayar')->nullable();
            // belum_bayar, menunggu_verifikasi, terverifikasi, ditolak
            $table->string('status_bayar')->default('belum_bayar');

            $table->foreign('id_order')->references('id_order')->on('orders')->cascadeOnDelete();
            $table->foreign('id_admin')->references('id_admin')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
