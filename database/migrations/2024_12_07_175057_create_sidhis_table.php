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
        Schema::create('sidhis', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('jemaat_id');
            $table->foreign('jemaat_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('jadwal_id');
            $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('cascade');
            $table->enum('status_verifikasi', ['diproses','disetujui', 'ditolak'])->default('diproses');
            $table->enum('status_kehadiran', ['belum', 'hadir', 'tidak hadir'])->default('belum');
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidhis');
    }
};
