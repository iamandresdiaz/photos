<?php
declare(strict_types=1);


namespace App\Photos\File\Domain\ValueObject;


final class FileDescription
{
    private $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function fileDescription(): string
    {
        return $this->description;
    }

    public function __toString()
    {
        return $this->fileDescription();
    }
}