<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_artikels', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('slug', 255)->unique();
            $table->string('warna', 7)->default('#3B82F6');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_artikels');
    }
};
