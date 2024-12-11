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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->date('tanggal');
            $table->time('jam');
            $table->string('pendeta_id');
            $table->foreign('pendeta_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('layanan_id');
            $table->foreign('layanan_id')->references('id')->on('layanans')->onDelete('cascade');
            $table->enum('jenis_bahasa', ['Indonesia', 'Jawa']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
