<?php

namespace App\Console\Commands;

use App\Services\PosMonitoringService;
use Illuminate\Console\Command;

class SyncStationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stations:sync {--wipe-dummy : Hapus stasiun dummy bawaan seeder sebelum sinkronisasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi 1.400+ stasiun dan pembacaan telemetri riil dari Pos Monitoring API';

    /**
     * Execute the console command.
     */
    public function handle(PosMonitoringService $service): int
    {
        $this->info('🚀 Memulai sinkronisasi stasiun dari Pos Monitoring API (http://103.183.75.71:5000)...');

        $wipeDummy = (bool) $this->option('wipe-dummy');
        if ($wipeDummy) {
            $this->warn('🧹 Menghapus stasiun dummy lama...');
        }

        $bar = null;

        try {
            $result = $service->syncAll($wipeDummy, function (int $current, int $total, string $name) use (&$bar) {
                if ($bar === null) {
                    $bar = $this->output->createProgressBar($total);
                    $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% - %message%');
                    $bar->setMessage('Menghubungkan...');
                    $bar->start();
                }

                $bar->setMessage(mb_substr($name, 0, 30));
                $bar->advance();
            });

            if ($bar !== null) {
                $bar->finish();
                $this->newLine(2);
            }

            $this->info('✅ Sinkronisasi stasiun selesai dengan sukses!');
            $this->table(
                ['Kategori', 'Jumlah'],
                [
                    ['Total Stasiun API', $result['total']],
                    ['Stasiun Baru (Created)', $result['created']],
                    ['Stasiun Diperbarui (Updated)', $result['updated']],
                    ['Gagal (Failed)', $result['failed']],
                ]
            );

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->newLine();
            $this->error('❌ Terjadi kesalahan saat sinkronisasi: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}

