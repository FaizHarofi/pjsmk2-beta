<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_artikel_id')->nullable()->constrained('kategori_artikels')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul', 255);
            $table->string('judul_en', 255)->nullable();
            $table->string('slug', 255)->unique();
            $table->text('ringkasan')->nullable();
            $table->text('ringkasan_en')->nullable();
            $table->mediumText('konten');
            $table->mediumText('konten_en')->nullable();
            $table->string('gambar', 500)->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
