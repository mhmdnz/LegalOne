<?php

namespace Tests\Unit\Modules\LogStatisticsModule\Services;

use App\Modules\LogStatisticsModule\Repositories\ElasticSearchAccessLogsRepository;
use App\Modules\LogStatisticsModule\Services\TruncateElasticSearchDatabaseService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use \PHPUnit\Framework\MockObject\MockObject;

class TruncateElasticSearchDatabaseServiceTest extends KernelTestCase
{
    private MockObject $repositoryMock;
    private TruncateElasticSearchDatabaseService $sut;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(ElasticSearchAccessLogsRepository::class);
        $this->sut = new TruncateElasticSearchDatabaseService($this->repositoryMock);
    }

    public function testTruncateIndicesSuccessfully()
    {
        // Arrange
        $this->repositoryMock
            ->expects($this->once())
            ->method('truncateIndices')
            ->willReturn(true);

        // Act
        $result = ($this->sut)();

        // Assert
        $this->assertTrue($result, "Service should return true when truncation is successful.");
    }

    public function testTruncateIndicesFailure()
    {
        // Arrange
        $this->repositoryMock
            ->expects($this->once())
            ->method('truncateIndices')
            ->willReturn(false);

        // Act
        $result = ($this->sut)();

        // Assert
        $this->assertFalse($result, "Service should return false when truncation fails.");
    }
}