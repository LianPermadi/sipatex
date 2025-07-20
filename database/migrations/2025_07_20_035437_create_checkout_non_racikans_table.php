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
        Schema::create('checkout_non_racikans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obat_id');
            $table->integer('qty');
            $table->unsignedBigInteger('signa_id');
            $table->dateTime('tanggal');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_non_racikans');
    }
};
