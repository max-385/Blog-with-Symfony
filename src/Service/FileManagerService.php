<?php


namespace App\Service;


use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerService implements FileManagerServiceInterface
{

    private $postImageDirectory;

    public function __construct($postImageDirectory)
    {
        $this->postImageDirectory = $postImageDirectory;
    }

    public function uploadPostImage(UploadedFile $file): string
    {
        $fileName = uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getPostImageDirectory(), $fileName);
        } catch (FileException $e) {
            return $e->getMessage();
        }

        return $fileName;
    }

    public function getPostImageDirectory()
    {
        return $this->postImageDirectory;
    }

    public function removePostImage($filename)
    {
        $fileSystem = new Filesystem();
        try {
            $fileSystem->remove($this->getPostImageDirectory() . '/' . $filename);
        } catch (IOException $e) {
            return $e->getMessage();
        }
    }
}