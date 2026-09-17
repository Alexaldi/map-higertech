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
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->enum('application_type', ['individual', 'group'])->default('individual')->after('type')->comment('individual=1 orang, group=tim/kelompok');
            $table->string('head_of_program')->nullable()->after('major')->comment('Nama/Jabatan Pimpinan Prodi atau Sekolah');
            $table->string('institution_address')->nullable()->after('institution')->comment('Alamat Kampus / Sekolah');
            $table->string('reference_number', 100)->nullable()->after('track')->comment('Nomor Surat Pengantar Kampus');
            $table->date('reference_date')->nullable()->after('reference_number')->comment('Tanggal Surat Pengantar Kampus');
            $table->string('acceptance_number', 100)->nullable()->after('status')->comment('Nomor Surat Balasan Higertech');
            $table->date('acceptance_date')->nullable()->after('acceptance_number')->comment('Tanggal Surat Balasan Diterbitkan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn([
                'application_type',
                'head_of_program',
                'institution_address',
                'reference_number',
                'reference_date',
                'acceptance_number',
                'acceptance_date',
            ]);
        });
    }
};

