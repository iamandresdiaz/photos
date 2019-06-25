<?php
declare(strict_types=1);

namespace App\Photos\File\Application\Add;


use App\Photos\File\Domain\Entity\File;
use App\Photos\File\Domain\ValueObject\FileFilter;
use App\Photos\File\Domain\ValueObject\FilePath;
use App\Photos\File\Domain\ValueObject\FileTag;
use App\Photos\File\Domain\ValueObject\FileType;
use App\Photos\File\Infrastructure\Persistence\MySqlFileRepository;
use App\Photos\File\Infrastructure\Persistence\SystemFileRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

final class AddFile
{
    private $systemFileRepository;
    private $mySqlFileRepository;

    public function __construct(
        SystemFileRepository $systemFileRepository,
        MySqlFileRepository $mySqlFileRepository
    ) {
        $this->systemFileRepository = $systemFileRepository;
        $this->mySqlFileRepository  = $mySqlFileRepository;
    }

    public function __invoke(Request $request): array
    {
        $files = [];
        $filesData = json_decode($request->getContent(), true);

        foreach ($filesData as $item)
        {
            $file = $this->getFile($item);
            $this->systemFileRepository->add($file);
            $this->mySqlFileRepository->add($file);
            $files[] = $file['info'];
        }

        return $files;
    }

    private function getFile(array $item): array
    {
        $fileData  = $item['file'];
        $tag       = new FileTag($item['tag']);
        $type      = new FileType(explode('/', $item['type'])[1]);
        $path      = new FilePath('images/' . Uuid::uuid4()->toString() . '.' . $type->__toString());
        $filter    = new FileFilter('original');
        $file      = new File($tag, $type, $path, $filter);

        return[
            'data' => $fileData,
            'info' => $file
        ];

    }
}