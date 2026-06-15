<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('nama_en', 255)->nullable();
            $table->string('slug', 255)->unique();
            $table->string('singkatan', 20)->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('deskripsi_en')->nullable();
            $table->string('gambar', 500)->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('warna', 7)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};
