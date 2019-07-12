<?php
declare(strict_types=1);


namespace App\Photos\File\Infrastructure\Persistence;


use App\Photos\File\Domain\Repository\FileRepository;
use UnexpectedValueException;

final class SystemFileRepository
{

    public function add(array $file): void
    {
        try{
            $fileDecode = base64_decode($file['base64']);
            file_put_contents($file['path'], $fileDecode);
        } catch (UnexpectedValueException $unexpectedValueException) {
            throw $unexpectedValueException;
        }

    }

}