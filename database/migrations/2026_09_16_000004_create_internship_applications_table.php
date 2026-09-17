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
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['university', 'vocational'])->default('university')->comment('university=Mahasiswa, vocational=SMK');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('identity_number', 50)->comment('NIM / NISN / NIK');
            $table->string('institution')->comment('Nama Universitas / Sekolah SMK');
            $table->string('major')->nullable()->comment('Jurusan / Program Studi (Khusus Mahasiswa)');
            $table->string('grade_level', 50)->comment('Semester / Tingkat Kelas');
            $table->string('phone', 30)->comment('Nomor WhatsApp');
            $table->date('start_date')->nullable()->comment('Tanggal Mulai Magang');
            $table->date('end_date')->nullable()->comment('Tanggal Selesai Magang');
            $table->string('duration', 50)->nullable()->comment('Durasi Magang terhitung otomatis');
            $table->string('start_period', 50)->nullable()->comment('Bulan Mulai Magang (YYYY-MM)');
            $table->string('track')->nullable()->comment('Peminatan / Bidang Magang (Termasuk input manual lainnya)');

            // Berkas Dokumen (Format PDF disimpan di storage/app/public/internships/...)
            $table->string('file_identity')->nullable()->comment('Scan KTM / Kartu Pelajar / KTP');
            $table->string('file_recommendation')->nullable()->comment('Surat Pengantar Kampus / Sekolah');
            $table->string('file_cv')->nullable()->comment('Curriculum Vitae / Portofolio');
            $table->string('file_transcript')->nullable()->comment('Transkrip Nilai / Rapor');

            // Status Review & Approval
            $table->enum('status', ['pending', 'reviewing', 'accepted', 'rejected'])->default('pending');
            $table->text('notes')->nullable()->comment('Catatan Pembina Magang');
            $table->timestamp('notified_at')->nullable()->comment('Waktu pengiriman notifikasi pengumuman');
            $table->timestamps();

            // Indexes for fast lookup & filtering in Admin Dashboard
            $table->index('type');
            $table->index('status');
            $table->index('phone');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};

