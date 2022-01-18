<?php

namespace App\Jobs;

use App\Services\FileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $fileUrl;
    private $fileService;

    public function __construct(string $fileUrl)
    {
        $this->fileUrl = $fileUrl;
        $this->fileService = resolve(FileService::class);
    }

    public function handle()
    {
        Log::info('Start processing file: ' . $this->fileUrl);

        $file = $this->fileService->findByUrl($this->fileUrl);
        $this->fileService->processFile($file);

        Log::info('Finish processing file: ' . $this->fileUrl);

        return;
    }
}
