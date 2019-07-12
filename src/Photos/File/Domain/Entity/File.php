<?php
declare(strict_types=1);


namespace App\Photos\File\Domain\Entity;


use App\Photos\File\Domain\ValueObject\FileDescription;
use App\Photos\File\Domain\ValueObject\FileFilter;
use App\Photos\File\Domain\ValueObject\FilePath;
use App\Photos\File\Domain\ValueObject\FileTag;
use App\Photos\File\Domain\ValueObject\FileType;
use DateTime;

final class File
{
    private $id;
    private $path;
    private $type;
    private $tag;
    private $description;
    private $filter;
    private $createdAt;

    public function __construct(
        FileTag $tag,
        FileDescription $description,
        FileType $type,
        FilePath $path,
        FileFilter $filter,
        DateTime $createdAt
    ) {
        $this->path        = $path->__toString();
        $this->tag         = $tag->__toString();
        $this->description = $description->__toString();
        $this->type        = $type->__toString();
        $this->filter      = $filter->__toString();
        $this->createdAt   = $createdAt;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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
        return $this->filter;
    }

    public function setFilter(string $filter): self
    {
        $this->filter = $filter;
        return $this;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt() :?DateTime
    {
        return $this->createdAt;
    }

}