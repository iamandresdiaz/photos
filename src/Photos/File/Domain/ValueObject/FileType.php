<?php
declare(strict_types=1);


namespace App\Photos\File\Domain\ValueObject;


final class FileType
{
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function fileType(): string
    {
        return $this->type;
    }

    public function __toString()
    {
        return $this->fileType();
    }
}