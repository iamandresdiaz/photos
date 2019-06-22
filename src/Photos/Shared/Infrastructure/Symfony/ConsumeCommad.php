<?php
declare(strict_types=1);


namespace App\Photos\Shared\Infrastructure\Symfony;

use App\Photos\Shared\Infrastructure\RabbitMQ\RabbitMQBunnyConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsumeCommad extends Command
{
    private $rabbitMQBunnyConsumer;
    protected static $defaultName = 'app:consume';

    public function __construct(RabbitMQBunnyConsumer $rabbitMQBunnyConsumer)
    {
        $this->rabbitMQBunnyConsumer = $rabbitMQBunnyConsumer;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Start a RabbitMQ consumer.')
            ->setHelp('This command allows you to start a RabbitMQ consumer.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Photos App Consumer',
            '====================',
            'Waiting for files',
        ]);

        $this->rabbitMQBunnyConsumer->__invoke();
    }
}