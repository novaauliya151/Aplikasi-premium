<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambah kolom payment_status untuk tracking verifikasi pembayaran
            // pending = menunggu upload bukti
            // awaiting_verification = sudah upload, menunggu admin verifikasi
            // verified = admin sudah verifikasi pembayaran
            // rejected = pembayaran ditolak
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status');
            }
            
            // status tetap untuk tracking aktivasi premium (paid/failed/pending)
            // paid = admin sudah aktivasi premium app di luar website
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
        });
    }
};
