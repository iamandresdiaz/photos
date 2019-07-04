<?php
declare(strict_types=1);


namespace App\Photos\File\Infrastructure\Persistence;


use App\Photos\File\Domain\Entity\File;
use App\Photos\File\Domain\Repository\FileRepository;
use App\Photos\Shared\Infrastructure\Redis\RedisClient;
use Doctrine\ORM\EntityManagerInterface;

final class MySqlFileRepository implements FileRepository
{
    private $entityManager;
    private $redisClient;

    public function __construct(EntityManagerInterface $entityManager, RedisClient $redisClient)
    {
        $this->entityManager = $entityManager;
        $this->redisClient   = $redisClient;
    }

    public function add(array $file): void
    {
        $this->entityManager->persist($file['info']);
        $this->entityManager->flush();
    }

    public function find(string $text): array
    {
        $files = $this->entityManager->getRepository(File::class)->findBy(array('tag' => $text));

        $response = [];

        foreach ($files as $file)
        {
            $response[] = $this->getFile($file);
        }

        return $response;
    }

    public function cachedFind(string $text): array
    {
        $cacheKey = __CLASS__ . __METHOD__ . '(' . $text . ')';

        $cacheItem = $this->redisClient->get($cacheKey);

        if ($cacheItem)
        {
            return json_decode($cacheItem, true);
        }

        $files = $this->find($text);

        $this->redisClient->set($cacheKey, json_encode($files));
        $this->redisClient->expire($cacheKey);

        return $files;

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