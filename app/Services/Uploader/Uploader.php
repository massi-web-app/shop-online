<?php

namespace App\Services\Uploader;

class Uploader implements UploaderInterface
{

    public function upload($file, $directory,$pixel=''): string|null
    {
        if (!empty($file)){
            $new_name_file = $pixel.$this->generateNewFileName($file->getClientOriginalExtension());
            if ($file->move($directory, $new_name_file)) {
                return $new_name_file;
            }
        }
        return null;


    }

    public function removeFile(string $directory, string $nameFile = null): void
    {
        if (!empty($nameFile)) {
            if (file_exists($directory . '/' . $nameFile)) {
                unlink($directory . '/' . $nameFile);
            }
        }

    }

    public function generateNewFileName($extension): string
    {
        return time() . '.' . $extension;
    }
}
