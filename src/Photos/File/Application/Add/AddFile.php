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

    public function __invoke(array $filesData): array
    {
        $files = [];

        foreach ($filesData as $item)
        {
            $file = $this->getFile(json_decode($item, true));
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