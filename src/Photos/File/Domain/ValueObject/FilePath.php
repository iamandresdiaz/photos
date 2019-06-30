<?php
declare(strict_types=1);


namespace App\Photos\File\Domain\ValueObject;


final class FilePath
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function filePath(): string
    {
        return $this->path;
    }

    public function __toString()
    {
        return $this->filePath();
    }
}