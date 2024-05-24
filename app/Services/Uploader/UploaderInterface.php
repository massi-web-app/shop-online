<?php

namespace App\Services\Uploader;

interface UploaderInterface
{
    public function upload($file, $directory): string|null;


    public function generateNewFileName(string $extension): string;

}
