<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Jobs\ProcessFile;
use App\Services\FileService;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    /**
     * @var FileService
     */
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function json(FileRequest $request)
    {
        $file = $this->saveFile($request);
        $this->fileService->processFile($file);
        return 'File Imported and processed with success!';
    }

    public function background(FileRequest $request)
    {
        $file = $this->saveFile($request);
        ProcessFile::dispatchAfterResponse($file->url);
        return 'File Imported with success! Now we gonna process';
    }

    public function saveFile(Request $request)
    {
        $file_path = $request->file('file')->store('unprocessed');
        return $this->fileService->create(['url' => $file_path]);
    }
}
