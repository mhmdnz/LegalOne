<?php

namespace App\Modules\LogStatisticsModule\Interfaces;

use App\Modules\LogStatisticsModule\DTOs\ElasticSearchFiltersDTO;
use App\Modules\LogStatisticsModule\DTOs\GetLogCountsDTO;

interface GetLogCountsByGivenFiltersServiceInterface
{
    public function __invoke(ElasticSearchFiltersDTO $elasticSearchFiltersDTO): GetLogCountsDTO;
}