<?php
declare(strict_types=1);

namespace App\Photos\File\Application\Add;


use App\Photos\File\Domain\ValueObject\FilePath;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;
use UnexpectedValueException;

final class AddFile
{

    public function __invoke(Request $request): array
    {
        $requestData = $request->getContent();
        $rawData = json_decode($requestData, true);

        $files = $rawData["files"];
        $paths = [];

        foreach ($files as $item)
        {
            $file = json_decode($item, true);
            $paths[] = $this->save($file);
        }

        return $paths;
    }

    private function save(array $file): FilePath
    {
        $fileInBase64 = $file["file"];
        $fileDecode   = base64_decode($fileInBase64);

        $type        = $file["type"];
        $typeExplode = explode('/', $type);
        $extension   = $typeExplode[1];
        $path        = new FilePath(Uuid::uuid4()->toString() . '.' . $extension);

        try{
            file_put_contents($path->__toString(), $fileDecode);
        } catch (UnexpectedValueException $unexpectedValueException){
            throw $unexpectedValueException;
        }

        return $path;
    }
}