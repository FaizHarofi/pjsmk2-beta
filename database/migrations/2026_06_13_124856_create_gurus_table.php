<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('nip', 30)->nullable();
            $table->string('foto', 500)->nullable();
            $table->string('jabatan', 255)->nullable();
            $table->string('mapel', 255)->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->string('email', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('jurusan_id')->references('id')->on('jurusans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
