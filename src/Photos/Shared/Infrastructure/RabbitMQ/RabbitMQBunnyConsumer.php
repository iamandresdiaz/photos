<?php
declare(strict_types=1);


namespace App\Photos\Shared\Infrastructure\RabbitMQ;


use App\Photos\File\Domain\Entity\File;
use App\Photos\File\Domain\ValueObject\FileFilter;
use App\Photos\File\Domain\ValueObject\FilePath;
use App\Photos\File\Domain\ValueObject\FileTag;
use App\Photos\File\Domain\ValueObject\FileType;
use App\Photos\File\Infrastructure\Persistence\MySqlFileRepository;
use App\Photos\Shared\Domain\Filter\FilterFactory;
use App\Photos\Shared\Infrastructure\SimpleImage\SimpleImageBuilder;
use Bunny\Channel;
use Bunny\Message;
use Bunny\Client;
use Bunny\Exception\ClientException;

final class RabbitMQBunnyConsumer
{
    private $rabbitMQBunnyClient;
    private $simpleImageBuilder;
    private $filterFactory;
    private $mySqlFileRepository;

    public function __construct(
        RabbitMQBunnyClient $rabbitMQBunnyClient,
        SimpleImageBuilder $simpleImageBuilder,
        MySqlFileRepository $mySqlFileRepository,
        FilterFactory $filterFactory
    ) {
        $this->rabbitMQBunnyClient = $rabbitMQBunnyClient;
        $this->simpleImageBuilder  = $simpleImageBuilder;
        $this->filterFactory       = $filterFactory;
        $this->mySqlFileRepository  = $mySqlFileRepository;
    }

    public function __invoke()
    {
        $client  = $this->rabbitMQBunnyClient->client();

        try {
            $client->connect();
        } catch (ClientException $clientException)
        {
            throw $clientException;
        }

        $channel = $client->channel();
        $channel->queueDeclare(RabbitMQBunnyClient::QUEUE);
        $channel->queueBind(RabbitMQBunnyClient::QUEUE, RabbitMQBunnyClient::EXCHANGE);

        $channel->run(
            function (Message $message, Channel $channel, Client $bunny) {
                $fileInfo = $this->jsonToArray($message);

                if ($fileInfo) {
                    $channel->ack($message);
                    echo 'applying ' . $fileInfo['filter_to_apply'] . ' filter to ' . $fileInfo['original_path'] . PHP_EOL;
                    $this->applyFilter($fileInfo);
                    $file = $this->getFile($fileInfo);
                    $this->mySqlFileRepository->add(['info' => $file]);
                    echo 'Finished' . PHP_EOL;
                    return;
                }

                $channel->nack($message);
            },
            RabbitMQBunnyClient::QUEUE
        );
    }

    private function jsonToArray(Message $message): array
    {
        return json_decode($message->content, true);
    }

    private function applyFilter($fileInfo): void
    {
        $this->filterFactory->create(
            $this->simpleImageBuilder->image(),
            $fileInfo
        );
    }

    private function getFile(array $fileInfo): File
    {
        $tag    = new FileTag($fileInfo['tag']);
        $type   = new FileType($fileInfo['type']);
        $path   = new FilePath($fileInfo['new_path']);
        $filter = new FileFilter($fileInfo['filter_to_apply']);

        return new File($tag,$type,$path,$filter);
    }
}