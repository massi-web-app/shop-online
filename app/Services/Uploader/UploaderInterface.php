<?php

namespace App\Services\Uploader;

interface UploaderInterface
{
    public function upload($file, $directory): string|null;

    public function removeFile(string $directory,string $nameFile=null): void;

    public function generateNewFileName(string $extension): string;

}
