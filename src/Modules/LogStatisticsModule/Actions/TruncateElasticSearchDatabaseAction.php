<?php

namespace App\Modules\LogStatisticsModule\Actions;

use App\Modules\LogStatisticsModule\Interfaces\TruncateElasticSearchDatabaseActionInterface;
use App\Modules\LogStatisticsModule\Interfaces\TruncateElasticSearchDatabaseServiceInterface;

class TruncateElasticSearchDatabaseAction implements TruncateElasticSearchDatabaseActionInterface
{
    public function __construct(private TruncateElasticSearchDatabaseServiceInterface $truncateElasticSearchDatabaseService)
    {
    }

    public function __invoke(): bool
    {
        return ($this->truncateElasticSearchDatabaseService)();
    }
}