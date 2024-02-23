<?php

namespace App\EventListeners;

use App\Exceptions\ElasticSearchIndexException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ElasticSearchIndexException) {
            $response = new JsonResponse([
                'error' => 'Elasticsearch index not found.',
                'details' => $exception->getMessage(),
            ]);

            $event->setResponse($response);
        }
    }
}