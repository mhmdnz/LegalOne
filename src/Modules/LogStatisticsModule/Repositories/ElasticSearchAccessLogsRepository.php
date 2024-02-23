<?php

namespace App\Modules\LogStatisticsModule\Repositories;

use App\Exceptions\ElasticSearchIndexException;
use App\Modules\LogStatisticsModule\DTOs\ElasticSearchFiltersDTO;
use Elasticsearch\Client;
use Psr\Log\LoggerInterface;

class ElasticSearchAccessLogsRepository
{
    public function __construct(
        private Client $client,
        private LoggerInterface $logger
    ) {
        ElasticSearchIndexException::setLogger($logger);
    }

    public function truncateIndices(): bool
    {
        try {
            $response = $this->client->indices()->delete(['index' => '*']);

            return $response['acknowledged'];
        }  catch (\Throwable $e) {
            ElasticSearchIndexException::checkAndThrow($e);

            return false;
        }
    }

    public function countByGivenFilter(ElasticSearchFiltersDTO $elasticSearchFiltersDTO): int
    {
        try {
            $searchQuery = $this->getSearchQuery($elasticSearchFiltersDTO);

            $results = $this->client->search($searchQuery);

            return $results["hits"]["total"]["value"];
        }  catch (\Throwable $e) {
            ElasticSearchIndexException::checkAndThrow($e);

            return 0;
        }
    }

    private function getSearchQuery(ElasticSearchFiltersDTO $elasticSearchFiltersDTO): array
    {
        $querySkeleton = [
            'index' => 'my-index',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [],
                        'should' => [],
                        'minimum_should_match' => 1,
                    ],
                ],
            ],
        ];

        $this->addDateRangeToQuery($elasticSearchFiltersDTO, $querySkeleton);
        $this->addStatusCodeToQuery($elasticSearchFiltersDTO, $querySkeleton);
        $this->addServiceNamesToQuery($elasticSearchFiltersDTO, $querySkeleton);

        return $querySkeleton;
    }

    private function addDateRangeToQuery(ElasticSearchFiltersDTO $elasticSearchFiltersDTO, array &$querySkeleton): void
    {
        $startDate = $elasticSearchFiltersDTO->startDate ? (new \DateTime($elasticSearchFiltersDTO->startDate))->format('d/M/Y:H:i:s O') : null;
        $endDate = $elasticSearchFiltersDTO->endDate ? (new \DateTime($elasticSearchFiltersDTO->endDate))->format('d/M/Y:H:i:s O') : null;

        if ($startDate || $endDate) {
            $rangeQuery = ['range' => ['timestamp' => []]];
            if ($startDate) {
                $rangeQuery['range']['timestamp']['gte'] = $startDate;
            }
            if ($endDate) {
                $rangeQuery['range']['timestamp']['lte'] = $endDate;
            }
            $querySkeleton['body']['query']['bool']['must'][] = $rangeQuery;
        }
    }

    private function addStatusCodeToQuery(ElasticSearchFiltersDTO $elasticSearchFiltersDTO, array &$querySkeleton): void
    {
        if ($elasticSearchFiltersDTO->statusCode) {
            $querySkeleton['body']['query']['bool']['must'][] = [
                'match' => ['response_code' => $elasticSearchFiltersDTO->statusCode],
            ];
        }
    }

    private function addServiceNamesToQuery(ElasticSearchFiltersDTO $elasticSearchFiltersDTO, array &$querySkeleton): void
    {
        if ($elasticSearchFiltersDTO->serviceNames) {
            foreach ($elasticSearchFiltersDTO->serviceNames as $serviceName) {
                $querySkeleton['body']['query']['bool']['should'][] = ['match' => ['service' => $serviceName]];
            }
        } else {
            unset($querySkeleton['body']['query']['bool']['should'], $querySkeleton['body']['query']['bool']['minimum_should_match']);
        }
    }
}