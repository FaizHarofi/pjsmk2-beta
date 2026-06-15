<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('album_galeri_id')->unsigned();
            $table->foreign('album_galeri_id')->references('id')->on('album_galeris')->onDelete('cascade');
            $table->string('judul', 255)->nullable();
            $table->string('file_path', 500);
            $table->enum('file_type', ['image', 'video'])->default('image');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('galeris');
    }
};
