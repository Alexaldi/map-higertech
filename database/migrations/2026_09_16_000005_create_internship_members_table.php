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
        Schema::create('internship_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_application_id')
                ->constrained('internship_applications')
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('identity_number', 50)->comment('NIM / NISN');
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->boolean('is_leader')->default(false);
            $table->string('file_identity')->nullable()->comment('Scan KTM / Kartu Pelajar');
            $table->string('file_cv')->nullable()->comment('CV / Portofolio anggota');
            $table->string('file_transcript')->nullable()->comment('Transkrip Nilai / Rapor anggota');
            $table->timestamps();

            $table->index('internship_application_id');
            $table->index('identity_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_members');
    }
};

