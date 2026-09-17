<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_application_id',
        'name',
        'identity_number',
        'email',
        'phone',
        'is_leader',
        'file_identity',
        'file_cv',
        'file_transcript',
    ];

    protected $casts = [
        'is_leader' => 'boolean',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(InternshipApplication::class, 'internship_application_id');
    }

    public function getFileIdentityUrlAttribute(): ?string
    {
        return $this->resolveFileUrl($this->file_identity);
    }

    public function getFileCvUrlAttribute(): ?string
    {
        return $this->resolveFileUrl($this->file_cv);
    }

    public function getFileTranscriptUrlAttribute(): ?string
    {
        return $this->resolveFileUrl($this->file_transcript);
    }

    private function resolveFileUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return url('storage/' . ltrim($path, '/'));
    }
}

