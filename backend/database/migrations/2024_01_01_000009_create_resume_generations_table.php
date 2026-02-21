<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resume_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('job_title');
            $table->string('company_name')->nullable();
            $table->text('job_description')->nullable();
            $table->foreignId('template_id')->nullable()->constrained('resume_templates')->nullOnDelete();
            $table->json('selected_skills')->nullable();
            $table->json('selected_experiences')->nullable();
            $table->json('selected_projects')->nullable();
            $table->json('selected_education')->nullable();
            $table->json('selected_certifications')->nullable();
            $table->text('custom_objective')->nullable();
            $table->text('additional_notes')->nullable();
            $table->string('generated_pdf_path')->nullable();
            $table->string('access_token')->unique();
            $table->boolean('is_public')->default(true);
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resume_generations');
    }
};
