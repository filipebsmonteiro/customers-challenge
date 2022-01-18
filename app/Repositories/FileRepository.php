<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;

class FileRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(File $file)
    {
        $this->model = $file;
    }

    public function create(array $attributes): File
    {
        return $this->model->create($attributes);
    }

    public function findByUrl(string $url): File
    {
        return $this->model->where('url', $url)->first();
    }
}
