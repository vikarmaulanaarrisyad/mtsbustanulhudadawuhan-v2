<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nomorwa');
            $table->string('nama_madrasah');
            $table->string('nama_yayasan');
            $table->string('nama_aplikasi');
            $table->string('singkatan');
            $table->text('tentang');
            $table->string('copyright');
            $table->string('logo')->default('default.png');
            $table->string('logo_login')->default('default.png');
            $table->string('favicon')->default('default.png');
            $table->string('background_image')->default('default.png');
            $table->string('login_background')->default('default.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
