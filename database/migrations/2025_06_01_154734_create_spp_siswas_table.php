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
        Schema::create('spp_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id');
            $table->date('tanggal_bayar');
            $table->string('bulan_bayar');
            $table->string('jumlah_bayar');
            $table->foreignId('tahun_pelajaran_id');
            $table->string('status_bayar');

            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tahun_pelajaran_id')->references('id')->on('master_tahun_pelajarans')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_siswas');
    }
};
