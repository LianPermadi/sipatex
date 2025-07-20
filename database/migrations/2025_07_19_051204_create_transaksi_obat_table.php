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
        Schema::create('transaksi_obat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obat_id');
            $table->unsignedBigInteger('signa_id');
            $table->integer('qty');
            $table->enum('tipe', ['non-racikan', 'racikan']);
            $table->string('racikan_nama')->nullable(); // <-- Tambahan kolom ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_obat');
    }
};
