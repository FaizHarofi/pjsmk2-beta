<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kategori_video_id')->unsigned()->nullable();
            $table->foreign('kategori_video_id')->references('id')->on('kategori_videos')->onDelete('set null');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->text('deskripsi')->nullable();
            $table->string('youtube_url', 500);
            $table->string('youtube_embed', 500)->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
