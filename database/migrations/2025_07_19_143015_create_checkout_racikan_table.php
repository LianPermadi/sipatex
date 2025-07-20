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
        Schema::create('checkout_racikan', function (Blueprint $table) {
            $table->id();
            $table->string('racikan_nama');
            $table->unsignedBigInteger('obat_id');
            $table->integer('qty');
            $table->unsignedBigInteger('signa_id')->nullable();
            $table->timestamp('checkout_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_racikan');
    }
};
