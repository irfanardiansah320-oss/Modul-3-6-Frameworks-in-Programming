<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PosterService
{
    private const DISK = 'public';
    private const DIRECTORY = 'posters';

    public function store(UploadedFile $file): string
    {
        return $file->store(self::DIRECTORY, self::DISK);
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk(self::DISK)->delete($path);
        }
    }
}