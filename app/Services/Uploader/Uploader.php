<?php

namespace App\Services\Uploader;

class Uploader implements UploaderInterface
{

    public function upload($file, $directory): string|null
    {
        $new_name_file = $this->generateNewFileName($file->getClientOriginalExtension());
        if ($file->move($directory, $new_name_file)) {
            return $new_name_file;
        }
        return null;

    }

    public function generateNewFileName($extension): string
    {
        return time() . '.' . $extension;
    }
}
