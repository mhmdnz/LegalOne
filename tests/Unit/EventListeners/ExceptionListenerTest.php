<?php

namespace Tests\Unit\EventListeners;

use App\EventListeners\ExceptionListener;
use App\Exceptions\ElasticSearchIndexException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ExceptionListenerTest extends KernelTestCase
{
    public function testOnKernelExceptionWithElasticSearchIndexException()
    {
        //Arrange
        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);
        $exception = new ElasticSearchIndexException('Index not found', 404);
        $event = new ExceptionEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST, $exception);
        $response = $event->getResponse();
        $listener = new ExceptionListener();

        //ACT
        $listener->onKernelException($event);
        $response = $event->getResponse();

        //Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([
            'error' => 'Elasticsearch index not found.',
            'details' => 'Index not found',
        ], json_decode($response->getContent(), true));
    }

    public function testOnKernelExceptionWithOtherException()
    {
        //Arrange
        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);
        $exception = new \Exception('General error', 500);
        $event = new ExceptionEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST, $exception);
        $listener = new ExceptionListener();

        //ACT
        $listener->onKernelException($event);

        // Assert : Expecting no response to be set for non-ElasticSearchIndexException exceptions.
        $this->assertNull($event->getResponse());
    }
}