<?php

namespace App\Modules\LogStatisticsModule\Actions;

use App\Modules\LogStatisticsModule\DTOs\ElasticSearchFiltersDTO;
use App\Modules\LogStatisticsModule\DTOs\GetLogCountsDTO;
use App\Modules\LogStatisticsModule\Interfaces\GetLogCountsByGivenFilterActionInterface;
use App\Modules\LogStatisticsModule\Interfaces\GetLogCountsByGivenFiltersServiceInterface;

class GetLogCountsByGivenFiltersAction implements GetLogCountsByGivenFilterActionInterface
{
    public function __construct(private GetLogCountsByGivenFiltersServiceInterface $getLogCountsByGivenFiltersService)
    {
    }

    public function __invoke(ElasticSearchFiltersDTO $elasticSearchFiltersDTO): GetLogCountsDTO
    {
        return ($this->getLogCountsByGivenFiltersService)($elasticSearchFiltersDTO);
    }
}