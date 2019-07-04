<?php
declare(strict_types=1);


namespace App\Photos\Shared\Infrastructure\Elasticsearch;


use Elastica\Client;

final class ElasticaClient
{
    const ELASTICA_CONNECTION = [
        'host' => 'elasticsearch',
        'port' => '9200'
    ];
    private $elasticaClient;

    public function __construct()
    {
        $this->elasticaClient = new Client(self::ELASTICA_CONNECTION);
    }

    public function client(): Client
    {
        return $this->elasticaClient;
    }
}
