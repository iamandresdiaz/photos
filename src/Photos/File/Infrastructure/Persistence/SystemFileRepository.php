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
            $fileDecode = base64_decode($file['data']);
            file_put_contents($file['info']->getPath(), $fileDecode);
        } catch (UnexpectedValueException $unexpectedValueException) {
            throw $unexpectedValueException;
        }

    }

}