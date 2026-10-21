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
        Schema::create('device_api_logs', function (Blueprint $table) {
            $table->id();
            $table->string('sub_domain', 100)->index();
            $table->string('endpoint', 255)->default('/api/device/store');
            $table->string('method', 10)->default('GET');
            $table->json('payload')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->unsignedSmallInteger('status_code')->default(200);
            $table->string('status', 20)->default('success')->index();
            $table->text('response_body')->nullable();
            $table->unsignedInteger('duration_ms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_api_logs');
    }
};
