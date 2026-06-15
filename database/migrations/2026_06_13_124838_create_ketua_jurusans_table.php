<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ketua_jurusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusans')->cascadeOnDelete();
            $table->string('nama', 255);
            $table->string('nip', 30)->nullable();
            $table->string('foto', 500)->nullable();
            $table->string('jabatan', 255)->nullable();
            $table->string('periode', 50)->nullable();
            $table->text('sambutan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ketua_jurusans');
    }
};
