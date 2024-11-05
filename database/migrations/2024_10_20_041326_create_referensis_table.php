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
        Schema::create('referensis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('keterangan')->nullable();
            $table->enum('tipe', ['link', 'file', 'image']);
            $table->string('path');
            $table->string('kode_pengajuan');
            $table->foreign('kode_pengajuan')->references('kode_pengajuan')->on('pengajuans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_files');
    }
};
