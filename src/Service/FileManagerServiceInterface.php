<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileManagerServiceInterface
{
    /**
     * @param UploadedFile $file
     * @return string
     */
    public function uploadPostImage(UploadedFile $file): string;

    /**
     * @param $filename
     * @return mixed
     */
    public function removePostImage($filename);
}