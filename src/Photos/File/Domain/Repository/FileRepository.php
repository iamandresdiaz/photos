<?php
declare(strict_types = 1);

namespace App\Photos\File\Domain\Repository;


use App\Photos\File\Domain\Entity\File;

interface FileRepository
{
    public function add(File $file):void;
    public function find(array $criteria):array;
    public function cachedFind(string $text):array;
}