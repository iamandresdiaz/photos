<?php
declare(strict_types = 1);

namespace App\Photos\File\Domain\Repository;


interface FileRepository
{
    public function add(array $file):void;
    public function find(string $text):array;
}