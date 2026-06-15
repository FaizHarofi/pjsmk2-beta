<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->text('deskripsi')->nullable();
            $table->string('gambar', 500)->nullable();
            $table->string('nama_siswa', 255)->nullable();
            $table->string('kelas', 50)->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->enum('tingkat', ['sekolah', 'kota', 'provinsi', 'nasional', 'internasional'])->default('sekolah');
            $table->year('tahun')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->foreign('jurusan_id')->references('id')->on('jurusans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};
