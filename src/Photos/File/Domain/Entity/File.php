<?php
declare(strict_types=1);


namespace App\Photos\File\Domain\Entity;


use App\Photos\File\Domain\ValueObject\FileData;
use App\Photos\File\Domain\ValueObject\FileFilter;
use App\Photos\File\Domain\ValueObject\FilePath;
use App\Photos\File\Domain\ValueObject\FileTag;
use App\Photos\File\Domain\ValueObject\FileType;

final class File
{
    private $id;
    private $data;
    private $path;
    private $type;
    private $tag;
    private $filter;

    public function __construct(
        FileTag $tag,
        FileType $type,
        FilePath $path,
        FileFilter $filter
    ) {
        $this->path   = $path->__toString();
        $this->tag    = $tag->__toString();
        $this->type   = $type->__toString();
        $this->filter = $filter->__toString();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getFilter(): ?string
    {
        return $this->type;
    }

    public function setFilter(string $type): self
    {
        $this->type = $type;
        return $this;
    }
}