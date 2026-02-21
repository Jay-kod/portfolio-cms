<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('project_type', ['Personal', 'Professional', 'Open Source', 'Academic'])->default('Personal');
            $table->json('technologies')->nullable();
            $table->string('role')->nullable();
            $table->integer('team_size')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_ongoing')->default(false);
            $table->string('github_url')->nullable();
            $table->string('live_url')->nullable();
            $table->string('image_url')->nullable();
            $table->json('highlights')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
