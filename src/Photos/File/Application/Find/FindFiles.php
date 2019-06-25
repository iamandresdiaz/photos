<?php
declare(strict_types=1);


namespace App\Photos\File\Application\Find;


use App\Photos\File\Domain\Entity\File;
use App\Photos\File\Infrastructure\Persistence\MySqlFileRepository;
use Symfony\Component\HttpFoundation\Request;

final class FindFiles
{
    private $mySqlFileRepository;

    public function __construct(
        MySqlFileRepository $mySqlFileRepository
    ) {
        $this->mySqlFileRepository  = $mySqlFileRepository;
    }

    public function __invoke(Request $request): array
    {
        $text  = json_decode($request->getContent(), true)['text'];
        $files = $this->mySqlFileRepository->find($text);

        $response = [];

        foreach ($files as $file)
        {
            $response[] = $this->getFile($file);
        }

        return $response;
    }

    private function getFile(File $file): array
    {
        return [
            'path'   => $file->getPath(),
            'tag'    => $file->getTag(),
            'type'   => $file->getType(),
            'filter' => $file->getFilter()
        ];
    }
}