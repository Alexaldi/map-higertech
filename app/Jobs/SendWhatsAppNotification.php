<?php

namespace App\Jobs;

use App\Models\InternshipApplication;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $timeout = 60;

    /**
     * Create a new job instance.
     *
     * @param int $applicationId
     * @param string $type ('new_application' | 'status_update')
     */
    public function __construct(
        public int $applicationId,
        public string $type
    ) {}

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $waService): void
    {
        $application = InternshipApplication::find($this->applicationId);
        if (! $application) {
            return;
        }

        try {
            if ($this->type === 'new_application') {
                $waService->notifyNewInternshipApplication($application);
            } elseif ($this->type === 'status_update') {
                $waService->notifyApplicantStatusUpdate($application);
            }
        } catch (\Throwable $e) {
            Log::error("SendWhatsAppNotification job failed for app {$this->applicationId}: " . $e->getMessage());
        }
    }

    /**
     * Helper to dispatch the job and trigger non-blocking execution in background.
     */
    public static function dispatchAsync(int $applicationId, string $type): void
    {
        self::dispatch($applicationId, $type);

        // Trigger background queue worker without blocking HTTP response
        self::triggerBackgroundWorker();
    }

    /**
     * Trigger background worker execution (Windows & Unix support).
     */
    public static function triggerBackgroundWorker(): void
    {
        // Skip background spawning in testing environment (handled synchronously by tests)
        if (app()->environment('testing') || app()->runningUnitTests()) {
            return;
        }

        try {
            $php = PHP_BINARY;
            $artisan = base_path('artisan');

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows non-blocking background execution
                pclose(popen("start /B \"\" \"{$php}\" \"{$artisan}\" queue:work --stop-when-empty > NUL 2>&1", 'r'));
            } else {
                // Linux / Unix non-blocking background execution
                exec("\"{$php}\" \"{$artisan}\" queue:work --stop-when-empty > /dev/null 2>&1 &");
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to trigger background queue worker: ' . $e->getMessage());
        }
    }
}
