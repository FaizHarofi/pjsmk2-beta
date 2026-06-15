<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontak_pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('email', 255);
            $table->string('subjek', 255)->nullable();
            $table->text('pesan');
            $table->boolean('is_read')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak_pesans');
    }
};
