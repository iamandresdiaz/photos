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
                'fuzzy' => [
                    'tag' => [
                        'value' => $text,
                        'boost' => '1.0',
                        'fuzziness' => '4',
                        'prefix_length' => '0',
                        'max_expansions' => '100'
                    ]
                ]
            ],
            'size' => 100,
            '_source' => ['tag']
        ];

        $response = $this->elasticaClient->request($path, Request::GET, $query);

        $documents = $response->getData()['hits']['hits'];

        $tags = [];

        foreach ($documents as $document) {
            $tags[] = $document['_source']['tag'];
        }

        return array_unique($tags);
    }
}