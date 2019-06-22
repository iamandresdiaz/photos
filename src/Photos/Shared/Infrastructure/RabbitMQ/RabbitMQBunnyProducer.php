<?php
declare(strict_types=1);


namespace App\Photos\Shared\Infrastructure\RabbitMQ;


use App\Photos\File\Domain\Entity\File;
use Bunny\Exception\ClientException;
use Ramsey\Uuid\Uuid;

final class RabbitMQBunnyProducer
{

    private $rabbitMQBunnyClient;

    public function __construct(RabbitMQBunnyClient $rabbitMQBunnyClient)
    {
        $this->rabbitMQBunnyClient = $rabbitMQBunnyClient;
    }

    public function __invoke(array $files, array $filters)
    {
        $client  = $this->rabbitMQBunnyClient->client();

        try {
            $client->connect();
        } catch (ClientException $clientException)
        {
            throw $clientException;
        }

        $channel = $client->channel();
        $channel->queueDeclare('files');

        foreach ($files as $file) {
            foreach ($filters as $key => $filter) {
                $channel->publish(
                    $this->getMessage($file, $filter),
                    [],
                    '',
                    'files'
                );
            }
        }

        $channel->close();
        $client->disconnect();
    }

    private function getMessage(File $file, string $filter): string
    {
        return json_encode(
            [
                'original_path'   => $file->getPath(),
                'new_path'        => 'images/' . Uuid::uuid4()->toString() . '.' . $file->getType(),
                'filter_to_apply' => $filter,
                'tag'             => $file->getTag(),
                'type'            => $file->getType()
            ]
        );
    }
}