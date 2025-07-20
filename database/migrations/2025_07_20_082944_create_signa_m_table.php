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
    Schema::create('signa_m', function (Blueprint $table) {
        $table->increments('signa_id');
        $table->string('signa_kode', 100)->nullable();
        $table->string('signa_nama', 250)->nullable();
        $table->text('additional_data')->nullable();
        $table->dateTime('created_date');
        $table->integer('created_by')->nullable();
        $table->integer('modified_count')->nullable();
        $table->dateTime('last_modified_date')->nullable();
        $table->integer('last_modified_by')->nullable();
        $table->boolean('is_deleted')->default(0);
        $table->boolean('is_active')->default(1);
        $table->dateTime('deleted_date')->nullable();
        $table->integer('deleted_by')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signa_m');
    }
};
