<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'product_id')) {
                $table->unsignedBigInteger('product_id')->after('id');
            }

            if (!Schema::hasColumn('orders', 'name')) {
                $table->string('name')->after('product_id');
            }

            if (!Schema::hasColumn('orders', 'address')) {
                $table->string('address')->after('name');
            }

            if (!Schema::hasColumn('orders', 'qty')) {
                $table->integer('qty')->after('address');
            }

            if (!Schema::hasColumn('orders', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('total');
            }

            if (!Schema::hasColumn('orders', 'payment_verified_at')) {
                $table->timestamp('payment_verified_at')->nullable()->after('payment_proof');
            }

            if (!Schema::hasColumn('orders', 'premium_access_sent')) {
                $table->tinyInteger('premium_access_sent')->default(0)->after('payment_verified_at');
            }
        });
    }


    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'product_id',
                'name',
                'address',
                'qty',
                'total',
                'payment_proof',
                'payment_verified_at',
                'premium_access_sent',
                'status'
            ]);
        });
    }

};
