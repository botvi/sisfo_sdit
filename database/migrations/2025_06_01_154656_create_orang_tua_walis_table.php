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
        Schema::create('orang_tua_walis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ibu');
            $table->string('nik_ibu');
            $table->string('nama_ayah');
            $table->string('nik_ayah');
            $table->text('alamat_ortu');
            $table->string('no_wa_ortu');
            $table->string('nama_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('no_wa_wali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tua_walis');
    }
};
