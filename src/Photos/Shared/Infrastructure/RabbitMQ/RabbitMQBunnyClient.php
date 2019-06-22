<?php
declare(strict_types=1);


namespace App\Photos\Shared\Infrastructure\RabbitMQ;


use Bunny\Client;

final class RabbitMQBunnyClient
{
    const CONNECTION = [
        'host'      => 'rabbitmq',
        'vhost'     => '/',
        'user'      => 'admin',
        'password'  => '1234',
    ];

    private $bunnyClient;

    public function __construct()
    {
        $this->bunnyClient = new Client(self::CONNECTION);
    }

    public function client(): Client
    {
        return $this->bunnyClient;
    }
}