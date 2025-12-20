<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // Tambah kolom jika belum ada
            if (!Schema::hasColumn('orders', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('total');
            }

            if (!Schema::hasColumn('orders', 'payment_verified_at')) {
                $table->timestamp('payment_verified_at')->nullable()->after('payment_proof');
            }

            if (!Schema::hasColumn('orders', 'premium_access_sent')) {
                $table->boolean('premium_access_sent')->default(false)->after('payment_verified_at');
            }

            // Jangan tambah kolom status kalau sudah ada
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')
                    ->default('pending')
                    ->after('premium_access_sent');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_proof')) {
                $table->dropColumn('payment_proof');
            }
            if (Schema::hasColumn('orders', 'payment_verified_at')) {
                $table->dropColumn('payment_verified_at');
            }
            if (Schema::hasColumn('orders', 'premium_access_sent')) {
                $table->dropColumn('premium_access_sent');
            }
            if (Schema::hasColumn('orders', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
