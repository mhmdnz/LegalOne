<?php

namespace Tests\Unit\Modules\LogStatisticsModule\Actions;

use App\Modules\LogStatisticsModule\Actions\TruncateElasticSearchDatabaseAction;
use App\Modules\LogStatisticsModule\Interfaces\TruncateElasticSearchDatabaseServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TruncateElasticSearchDatabaseActionTest extends KernelTestCase
{
    private MockObject $truncateElasticSearchDatabaseServiceMock;
    private TruncateElasticSearchDatabaseAction $sut;

    protected function setUp(): void
    {
        $this->truncateElasticSearchDatabaseServiceMock = $this
            ->createMock(TruncateElasticSearchDatabaseServiceInterface::class);
        $this->sut = new TruncateElasticSearchDatabaseAction($this->truncateElasticSearchDatabaseServiceMock);
    }

    public function testInvokeReturnsTrue()
    {
        // ARRANGE
        $this->truncateElasticSearchDatabaseServiceMock
            ->expects($this->once()) // Expect the method to be called exactly once
            ->method('__invoke')
            ->willReturn(true);

        // ACT
        $result = ($this->sut)();

        // Assert
        $this->assertTrue($result, "The action should return true as the service indicates success.");
    }

    public function testInvokeReturnsFalse()
    {
        // ARRANGE
        $this->truncateElasticSearchDatabaseServiceMock
            ->expects($this->once()) // Expect the method to be called exactly once
            ->method('__invoke')
            ->willReturn(false);

        // ACT
        $result = ($this->sut)();

        // Assert
        $this->assertFalse($result, "The action should return false as the service indicates failure.");
    }
}