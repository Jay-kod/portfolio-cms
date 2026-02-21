<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 500);
            $table->string('page_name', 100)->nullable();
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('device_type', 20)->nullable(); // desktop, mobile, tablet
            $table->string('browser', 50)->nullable();
            $table->string('country', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('created_at');
            $table->index('path');
            $table->index('device_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
