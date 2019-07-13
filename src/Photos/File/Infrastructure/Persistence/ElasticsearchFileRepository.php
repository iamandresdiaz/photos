<?php
declare(strict_types=1);


namespace App\Photos\File\Infrastructure\Persistence;


use App\Photos\File\Domain\Entity\File;
use App\Photos\Shared\Infrastructure\Elasticsearch\ElasticaClient;
use Elastica\Document;
use Elastica\Request;

final class ElasticsearchFileRepository
{
    const FILES_ELASTIC_INDEX_KEY = 'files';
    const FILE_ELASTIC_TYPE_KEY = 'file';

    private $elasticaClient;

    public function __construct(ElasticaClient $elasticaClient)
    {
        $this->elasticaClient = $elasticaClient->client();
    }

    public function add(File $file): void
    {
        $this->elasticaClient->connect();

        $elasticaIndex = $this->elasticaClient->getIndex(self::FILES_ELASTIC_INDEX_KEY);
        $elasticaType = $elasticaIndex->getType(self::FILE_ELASTIC_TYPE_KEY);

        $fileData = [
            'path' => $file->getPath(),
            'tag' => $file->getTag(),
            'description' => $file->getDescription(),
            'type' => $file->getType(),
            'filter' => $file->getFilter(),
            'created_at' => $file->getCreatedAt()
        ];

        $fileDocument = new Document('', $fileData);

        $elasticaType->addDocument($fileDocument);

        $elasticaIndex->refresh();

    }

    public function find(string $text): array
    {
        $path = '/_search';

        $query = [
            'query' => [
                'multi_match' => [
                    'query'  => $text,
                    'fields' => [
                        'tag',
                        'description'
                    ],
                    'fuzziness' => 'AUTO',
                    'prefix_length' => '2'
                ]
            ],
            'size' => 50,
            '_source' => ['tag', 'description']
        ];

        $response = $this->elasticaClient->request($path, Request::GET, $query);

        $documents = $response->getData()['hits']['hits'];

        $tags         = [];
        $descriptions = [];

        foreach ($documents as $document) {
            $tags[] = $document['_source']['tag'];
            $descriptions[] = $document['_source']['description'];
        }

        return [
            'tags'         => array_unique($tags),
            'descriptions' => array_unique($descriptions)
        ];
    }
}