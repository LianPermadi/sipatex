<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObatalkesMTable extends Migration
{
    public function up()
    {
        Schema::create('obatalkes_m', function (Blueprint $table) {
            $table->id('obatalkes_id');
            $table->string('obatalkes_kode', 100)->nullable();
            $table->string('obatalkes_nama', 250)->nullable();
            $table->decimal('stok', 15, 2)->nullable();
            $table->text('additional_data')->nullable();
            $table->dateTime('created_date');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->integer('modified_count')->nullable();
            $table->dateTime('last_modified_date')->nullable();
            $table->unsignedBigInteger('last_modified_by')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->boolean('is_active')->default(1);
            $table->dateTime('deleted_date')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('obatalkes_m');
    }
}

