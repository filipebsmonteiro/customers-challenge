<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    const UNPROCESSED = 'unprocessed';
    const PROCESSED = 'processed';

    protected $fillable = [
        'url',
        'stage'
    ];

    public function setProcessed(): self
    {
        $this->stage = self::PROCESSED;
        $pathArray = explode('/', $this->url);
        $this->url = self::PROCESSED . '/' . end($pathArray);
        $this->save();
        return $this;
    }
}
