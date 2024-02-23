<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\ElasticSearchIndexException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ElasticSearchIndexExceptionTest extends KernelTestCase
{
    public function testSetLogger()
    {
        //Arrange
        $mockLogger = $this->createMock(LoggerInterface::class);

        //ACT
        ElasticSearchIndexException::setLogger($mockLogger);

        //ASSERT(To make sure our code reach to last line and no one removed setLogger)
        $this->addToAssertionCount(1);
    }

    public function testCheckAndThrowWithIndexNotFoundException()
    {
        //Arrange
        $mockLogger = $this->createMock(LoggerInterface::class);
        ElasticSearchIndexException::setLogger($mockLogger);

        $message = json_encode(['error' => ['type' => 'index_not_found_exception']]);
        $exception = new Exception($message, 404);

        $mockLogger->expects($this->once())
            ->method('error')
            ->with($this->stringContains('Exception occurred:'), $this->arrayHasKey('exception'));

        $this->expectException(ElasticSearchIndexException::class);

        //ACT
        ElasticSearchIndexException::checkAndThrow($exception);
    }

    public function testCheckAndThrowWithOtherException()
    {
        //Arrange
        $mockLogger = $this->createMock(LoggerInterface::class);
        ElasticSearchIndexException::setLogger($mockLogger);

        $message = json_encode(['error' => ['type' => 'other_exception']]);
        $exception = new Exception($message, 500);


        $mockLogger->expects($this->once())
            ->method('error')
            ->with($this->stringContains('Exception occurred:'), $this->arrayHasKey('exception'));

        //ACT
        ElasticSearchIndexException::checkAndThrow($exception);

        //ASSERT
        $this->addToAssertionCount(1);
    }
}