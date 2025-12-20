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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('product_variants')->onDelete('cascade');
            $table->string('name'); // Nama promo, misal: "Diskon Akhir Tahun"
            $table->enum('type', ['nominal', 'percent']); // Tipe diskon
            $table->decimal('value', 12, 2); // Nilai diskon (nominal atau persen)
            $table->date('start_date'); // Tanggal mulai promo
            $table->date('end_date'); // Tanggal berakhir promo
            $table->boolean('is_active')->default(true); // Aktif/nonaktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
