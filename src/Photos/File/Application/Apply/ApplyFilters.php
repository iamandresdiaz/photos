<?php
declare(strict_types=1);


namespace App\Photos\File\Application\Apply;


use App\Photos\Shared\Domain\Filter\FilterFactory;
use App\Photos\Shared\Infrastructure\RabbitMQ\RabbitMQBunnyProducer;

final class ApplyFilters
{
    const FILTERS = [
        FilterFactory::FILTER_SEPIA,
        FilterFactory::FILTER_DESATURATE,
        FilterFactory::FILTER_SKETCH,
        FilterFactory::FILTER_INVERT,
        FilterFactory::FILTER_PIXELATE
    ];

    private $rabbitMQBunnyProducer;

    public function __construct(RabbitMQBunnyProducer $rabbitMQBunnyProducer)
    {
        $this->rabbitMQBunnyProducer = $rabbitMQBunnyProducer;
    }

    public function __invoke(array $files)
    {
        $filters = self::FILTERS;
        $this->rabbitMQBunnyProducer->__invoke($files, $filters);
    }
}