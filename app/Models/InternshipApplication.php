<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternshipApplication extends Model
{
    protected $fillable = [
        'type',
        'application_type',
        'name',
        'email',
        'identity_number',
        'institution',
        'institution_address',
        'major',
        'head_of_program',
        'grade_level',
        'phone',
        'duration',
        'start_period',
        'start_date',
        'end_date',
        'track',
        'reference_number',
        'reference_date',
        'file_identity',
        'file_recommendation',
        'file_cv',
        'file_transcript',
        'status',
        'acceptance_number',
        'acceptance_date',
        'notes',
        'notified_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'reference_date' => 'date',
            'acceptance_date' => 'date',
            'notified_at' => 'datetime',
        ];
    }

    // Relationships
    public function members(): HasMany
    {
        return $this->hasMany(InternshipMember::class, 'internship_application_id');
    }

    // Scopes
    public function scopeUniversity(Builder $query): Builder
    {
        return $query->where('type', 'university');
    }

    public function scopeVocational(Builder $query): Builder
    {
        return $query->where('type', 'vocational');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    // Accessors & Helpers
    public function getRegistrationCodeAttribute(): string
    {
        $prefix = $this->type === 'vocational' ? 'SMK' : 'UNV';
        $year = $this->created_at ? $this->created_at->format('y') : date('y');
        return sprintf('INT-%s%s-%04d', $prefix, $year, $this->id);
    }

    public function getIsGroupAttribute(): bool
    {
        return $this->application_type === 'group' || $this->members()->count() > 1;
    }

    /**
     * Get all members including leader.
     * If no members rows exist, dynamically synthesize a member record from the applicant's main fields.
     */
    public function getAllMembersAttribute(): Collection
    {
        $members = $this->relationLoaded('members') ? $this->members : $this->members()->get();

        if ($members->isNotEmpty()) {
            return $members;
        }

        // Synthesize leader as single member for backward-compatibility
        $synthetic = new InternshipMember([
            'internship_application_id' => $this->id,
            'name' => $this->name,
            'identity_number' => $this->identity_number,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_leader' => true,
            'file_identity' => $this->file_identity,
            'file_cv' => $this->file_cv,
            'file_transcript' => $this->file_transcript,
        ]);

        return new Collection([$synthetic]);
    }

    public function getPeriodFormattedAttribute(): string
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
        }
        if ($this->start_date) {
            return 'Mulai ' . $this->start_date->format('d M Y');
        }
        return $this->start_period ?: '-';
    }

    /**
     * Indonesian formatted period for the official letter (e.g. 10 Agustus 2026 s.d. 30 September 2026).
     */
    public function getPeriodLetterFormattedAttribute(): string
    {
        if ($this->start_date && $this->end_date) {
            return $this->formatIndonesianDate($this->start_date) . ' s.d. ' . $this->formatIndonesianDate($this->end_date);
        }

        return $this->period_formatted;
    }

    public function getAcceptanceNumberFormattedAttribute(): string
    {
        if (! empty($this->acceptance_number)) {
            return $this->acceptance_number;
        }

        $date = $this->acceptance_date ?? $this->updated_at ?? now();
        $romanMonth = $this->getRomanMonth($date->format('n'));
        return sprintf('%03d/SP.KP/HGT/%s/%s', $this->id, $romanMonth, $date->format('Y'));
    }

    public function getAcceptanceDateFormattedAttribute(): string
    {
        $date = $this->acceptance_date ?? $this->updated_at ?? now();
        return $this->formatIndonesianDate($date);
    }

    public function getReferenceDateFormattedAttribute(): ?string
    {
        return $this->reference_date ? $this->formatIndonesianDate($this->reference_date) : null;
    }

    private function getRomanMonth(int $month): string
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        return $map[$month] ?? 'I';
    }

    private function formatIndonesianDate($date): string
    {
        if (! $date instanceof Carbon) {
            $date = Carbon::parse($date);
        }

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return sprintf('%d %s %d', $date->format('j'), $months[(int) $date->format('n')], $date->format('Y'));
    }

    public function getBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-warning-transparent text-warning border border-warning',
            'reviewing' => 'bg-info-transparent text-info border border-info',
            'accepted' => 'bg-success-transparent text-success border border-success',
            'rejected' => 'bg-danger-transparent text-danger border border-danger',
            default => 'bg-secondary-transparent text-secondary border border-secondary',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'vocational' => 'SMK / MAK',
            default => 'Mahasiswa / D3 / S1',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Review',
            'reviewing' => 'Sedang Diproses',
            'accepted' => 'Diterima (ACC)',
            'rejected' => 'Tidak Diterima',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-300 dark:border-amber-700',
            'reviewing' => 'bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 border border-blue-300 dark:border-blue-700',
            'accepted' => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-700',
            'rejected' => 'bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 border border-rose-300 dark:border-rose-700',
            default => 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700',
        };
    }

    public function getFileIdentityUrlAttribute(): ?string
    {
        return $this->resolveFileUrl($this->file_identity);
    }

    public function getFileRecommendationUrlAttribute(): ?string
    {
        return $this->resolveFileUrl($this->file_recommendation);
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
