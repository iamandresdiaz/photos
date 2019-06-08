<?php
declare(strict_types=1);


namespace App\Photos\Photo\Application\Save;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;
use Exception;

final class SaveFile
{
    public function __construct()
    {
    }

    public function __invoke(Request $request): void
    {
        $requestData = $request->getContent();
        $rawData = json_decode($requestData, true);
        $file = $rawData["file"];
        $fileDecode = base64_decode($file);
        $type = $rawData["type"];
        $typeExplode = explode('/', $type);
        $extension = $typeExplode[1];
        $filePath = Uuid::uuid4()->toString() . '.' . $extension;
        file_put_contents($filePath, $fileDecode);

    }
}