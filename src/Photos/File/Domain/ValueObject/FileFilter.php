<?php
declare(strict_types=1);


namespace App\Photos\File\Domain\ValueObject;


final class FileFilter
{
    private $filter;

    public function __construct(string $filter)
    {
        $this->filter = $filter;
    }

    public function fileFilter(): string
    {
        return $this->filter;
    }

    public function __toString()
    {
        return $this->fileFilter();
    }
}