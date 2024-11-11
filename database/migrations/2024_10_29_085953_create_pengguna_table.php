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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->increments('id'); // Auto-incrementing primary key (int(11) NOT NULL)
            $table->string('nama', 255)->nullable()->default(null); // varchar(255) DEFAULT NULL
            $table->string('kad_pengenalan', 20)->nullable()->default(null); // varchar(20) DEFAULT NULL
            $table->string('bahagian', 255)->nullable()->default(null); // varchar(255) DEFAULT NULL
            $table->string('jawatan', 255)->nullable()->default(null); // varchar(255) DEFAULT NULL
            $table->unsignedInteger('peranan'); // int(11) NOT NULL
            $table->string('emel', 255)->nullable()->default(null); // varchar(255) DEFAULT NULL
            $table->string('no_tel', 15)->nullable()->default(null); // varchar(15) DEFAULT NULL
            $table->string('status', 255)->nullable()->default(null); // varchar(255) DEFAULT NULL
            $table->string('kata_laluan', 100)->nullable()->default(null); // varchar(100) DEFAULT NULL
            $table->timestamps(0);

            // Foreign key constraint
            $table->foreign('peranan')->references('id')->on('peranan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
