<?php

namespace App\Modules\LogStatisticsModule\Services;

use App\Modules\LogStatisticsModule\DTOs\ElasticSearchFiltersDTO;
use App\Modules\LogStatisticsModule\DTOs\GetLogCountsDTO;
use App\Modules\LogStatisticsModule\Interfaces\GetLogCountsByGivenFiltersServiceInterface;
use App\Modules\LogStatisticsModule\Repositories\ElasticSearchAccessLogsRepository;

class GetLogCountsByGivenFiltersService implements GetLogCountsByGivenFiltersServiceInterface
{
    public function __construct(private ElasticSearchAccessLogsRepository $elasticSearchAccessLogsRepository)
    {
    }

    public function __invoke(ElasticSearchFiltersDTO $elasticSearchFiltersDTO): GetLogCountsDTO
    {
        $result = $this->elasticSearchAccessLogsRepository->countByGivenFilter($elasticSearchFiltersDTO);

        return new GetLogCountsDTO($result);
    }
}