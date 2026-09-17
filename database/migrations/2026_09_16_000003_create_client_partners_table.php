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
        Schema::create('client_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sub')->nullable();
            $table->string('abbr', 20)->default('PU');
            $table->string('color')->default('bg-amber-400 text-slate-950');
            $table->string('logo')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_partners');
    }
};

