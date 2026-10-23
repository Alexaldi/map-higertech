<?php

namespace App\Http\Controllers\Admin\Concerns;

/**
 * Helper bersama untuk fitur ekspor CSV/PDF di panel admin.
 */
trait HandlesExports
{
    /**
     * Naikkan memory_limit hanya untuk request ini (dompdf menyusun seluruh dokumen di memori),
     * dan hanya jika batas saat ini lebih kecil
     */
    protected function raiseMemoryLimit(string $limit = '256M'): void
    {
        $toBytes = function (string $value): int {
            $value = trim($value);
            if ($value === '-1') {
                return PHP_INT_MAX;
            }

            $number = (int) $value;

            return match (strtolower(substr($value, -1))) {
                'g'     => $number * 1024 ** 3,
                'm'     => $number * 1024 ** 2,
                'k'     => $number * 1024,
                default => $number,
            };
        };

        if ($toBytes((string) ini_get('memory_limit')) < $toBytes($limit)) {
            @ini_set('memory_limit', $limit);
        }
    }

    /**
     * Cegah CSV/formula injection saat file dibuka di Excel (data dari perangkat/server balai tidak terpercaya)
     */
    protected function sanitizeCsvCell(?string $value): string
    {
        $value = (string) $value;

        return $value !== '' && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true) ? "'" . $value : $value;
    }
}
