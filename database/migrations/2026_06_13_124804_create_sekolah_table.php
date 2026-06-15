<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('nama_en', 255)->nullable();
            $table->string('npsn', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->text('alamat_en')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('favicon', 500)->nullable();
            $table->string('hero_image', 500)->nullable();
            $table->text('visi')->nullable();
            $table->text('visi_en')->nullable();
            $table->text('misi')->nullable();
            $table->text('misi_en')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('sejarah_en')->nullable();
            $table->text('kata_sambutan')->nullable();
            $table->text('kata_sambutan_en')->nullable();
            $table->string('foto_kepsek', 500)->nullable();
            $table->string('nama_kepsek', 255)->nullable();
            $table->string('facebook_url', 500)->nullable();
            $table->string('instagram_url', 500)->nullable();
            $table->string('youtube_url', 500)->nullable();
            $table->string('tiktok_url', 500)->nullable();
            $table->string('twitter_url', 500)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};
