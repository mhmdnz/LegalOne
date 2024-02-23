<?php

namespace App\Modules\LogStatisticsModule\Services;

use App\Modules\LogStatisticsModule\Interfaces\TruncateElasticSearchDatabaseServiceInterface;
use App\Modules\LogStatisticsModule\Repositories\ElasticSearchAccessLogsRepository;

class TruncateElasticSearchDatabaseService implements TruncateElasticSearchDatabaseServiceInterface
{
    public function __construct(private ElasticSearchAccessLogsRepository $elasticSearchAccessLogsRepository)
    {
    }

    public function __invoke(): bool
    {
        return ($this->elasticSearchAccessLogsRepository)->truncateIndices();
    }
}