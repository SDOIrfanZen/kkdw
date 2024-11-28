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
        Schema::create('rejected_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kad_pengenalan');
            $table->string('email');
            $table->string('bahagian');
            $table->string('no_tel');
            $table->string('jawatan');
            $table->text('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejected_pengguna');
    }
};
