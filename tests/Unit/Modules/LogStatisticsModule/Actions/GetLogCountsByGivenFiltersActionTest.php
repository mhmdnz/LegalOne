<?php

use App\Modules\LogStatisticsModule\Actions\GetLogCountsByGivenFiltersAction;
use App\Modules\LogStatisticsModule\DTOs\ElasticSearchFiltersDTO;
use App\Modules\LogStatisticsModule\DTOs\GetLogCountsDTO;
use App\Modules\LogStatisticsModule\Interfaces\GetLogCountsByGivenFiltersServiceInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use \PHPUnit\Framework\MockObject\MockObject;

class GetLogCountsByGivenFiltersActionTest extends KernelTestCase
{
    private MockObject $getLogCountsByGivenFiltersServiceMock;
    private GetLogCountsByGivenFiltersAction $sut;

    protected function setUp(): void
    {
        $this->getLogCountsByGivenFiltersServiceMock = $this->createMock(GetLogCountsByGivenFiltersServiceInterface::class);
        $this->sut = new GetLogCountsByGivenFiltersAction($this->getLogCountsByGivenFiltersServiceMock);
    }

    public function testInvoke()
    {
        // Arrange
        $elasticSearchFiltersDTO = new ElasticSearchFiltersDTO();
        $expectedResult = new GetLogCountsDTO(10);

        $this->getLogCountsByGivenFiltersServiceMock
            ->expects($this->once())
            ->method('__invoke')
            ->with($elasticSearchFiltersDTO)
            ->willReturn($expectedResult);

        // ACT
        $result = ($this->sut)($elasticSearchFiltersDTO);

        // ASSERT
        $this->assertSame($expectedResult, $result, "The action should return the result from the service.");
    }
}