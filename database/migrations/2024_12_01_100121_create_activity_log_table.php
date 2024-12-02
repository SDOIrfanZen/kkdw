<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject');
            $table->nullableMorphs('causer');
            $table->text('properties')->nullable(); // Changed from `json` to `text`
            $table->timestamp('created_at')->nullable();
        });
        
    }

    public function down(): void {
        Schema::dropIfExists('activity_log');
    }
};

