<?php

namespace Tests\Unit\Modules\LogStatisticsModule\Services;

use App\Modules\LogStatisticsModule\DTOs\ElasticSearchFiltersDTO;
use App\Modules\LogStatisticsModule\DTOs\GetLogCountsDTO;
use App\Modules\LogStatisticsModule\Repositories\ElasticSearchAccessLogsRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Modules\LogStatisticsModule\Services\GetLogCountsByGivenFiltersService;
use \PHPUnit\Framework\MockObject\MockObject;

class GetLogCountsByGivenFiltersServiceTest extends KernelTestCase
{
    private MockObject $elasticSearchAccessLogsRepositoryMock;
    private GetLogCountsByGivenFiltersService $sut;

    protected function setUp(): void
    {
        $this->elasticSearchAccessLogsRepositoryMock = $this
            ->createMock(ElasticSearchAccessLogsRepository::class);
        $this->sut = new GetLogCountsByGivenFiltersService($this->elasticSearchAccessLogsRepositoryMock);
    }

    public function testInvoke()
    {
        // Arrange
        $elasticSearchFiltersDTO = new ElasticSearchFiltersDTO();
        $expectedCount = 10;
        $this->elasticSearchAccessLogsRepositoryMock
            ->method('countByGivenFilter')
            ->with($elasticSearchFiltersDTO)
            ->willReturn($expectedCount);

        // ACT
        $result = ($this->sut)($elasticSearchFiltersDTO);

        // ASSERT
        $this->assertInstanceOf(GetLogCountsDTO::class, $result);
        $this->assertEquals(
            $expectedCount,
            $result->count,
            "The count returned by the service should match the expected count."
        );
    }
}