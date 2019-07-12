<?php
declare(strict_types=1);

namespace App\Photos\File\Application\Add;


use App\Photos\File\Domain\Entity\File;
use App\Photos\File\Domain\ValueObject\FileDescription;
use App\Photos\File\Domain\ValueObject\FileFilter;
use App\Photos\File\Domain\ValueObject\FilePath;
use App\Photos\File\Domain\ValueObject\FileTag;
use App\Photos\File\Domain\ValueObject\FileType;
use App\Photos\File\Infrastructure\Persistence\ElasticsearchFileRepository;
use App\Photos\File\Infrastructure\Persistence\MySqlFileRepository;
use App\Photos\File\Infrastructure\Persistence\SystemFileRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

final class AddFile
{
    private $systemFileRepository;
    private $mySqlFileRepository;
    private $elasticsearchFileRepository;

    public function __construct(
        SystemFileRepository $systemFileRepository,
        MySqlFileRepository $mySqlFileRepository,
        ElasticsearchFileRepository $elasticsearchFileRepository
    ) {
        $this->systemFileRepository = $systemFileRepository;
        $this->mySqlFileRepository  = $mySqlFileRepository;
        $this->elasticsearchFileRepository = $elasticsearchFileRepository;
    }

    public function __invoke(Request $request): array
    {
        $files = [];
        $filesData = json_decode($request->getContent(), true);

        foreach ($filesData as $item)
        {
            $file = $this->getFile($item);
            $fileData = $this->getFileDataToSaveInSystem($item['file'], $file->getPath());
            $this->systemFileRepository->add($fileData);
            $this->mySqlFileRepository->add($file);
            $this->elasticsearchFileRepository->add($file);
            $files[] = $file;
        }

        return $files;
    }

    private function getFile(array $item): File
    {
        $tag         = new FileTag($item['tag']);
        $description = new FileDescription($item['description']);
        $type        = new FileType(explode('/', $item['type'])[1]);
        $path        = new FilePath('images/' . Uuid::uuid4()->toString() . '.' . $type->__toString());
        $filter      = new FileFilter('original');
        $createdAt   = new DateTime('now');
        $file        = new File($tag, $description, $type, $path, $filter, $createdAt);

        return $file;
    }

    private function getFileDataToSaveInSystem(string $file, string $path)
    {
        return [
            'base64' => $file,
            'path'   => $path
        ];
    }

}