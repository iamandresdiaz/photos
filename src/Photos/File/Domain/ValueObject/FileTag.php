<?php
declare(strict_types=1);


namespace App\Photos\File\Domain\ValueObject;


final class FileTag
{
    private $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function fileTag(): string
    {
        return $this->tag;
    }

    public function __toString()
    {
        return $this->fileTag();
    }
}