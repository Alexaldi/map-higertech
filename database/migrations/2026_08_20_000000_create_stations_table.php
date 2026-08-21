<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stations', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('station_type')->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('balai_name')->nullable();
            $table->string('organization_code')->nullable()->index();
            $table->string('province_name')->nullable();
            $table->string('regency_name')->nullable();
            $table->string('district_name')->nullable();
            $table->string('village_name')->nullable();
            $table->string('river_area_name')->nullable();
            $table->string('watershed_name')->nullable();
            $table->string('device_id')->nullable();
            $table->string('device_status')->default('online')->index();
            $table->string('timezone')->default('Asia/Jakarta');
            $table->timestamp('reading_at')->nullable();
            $table->json('latest_reading')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stations');
    }
};
