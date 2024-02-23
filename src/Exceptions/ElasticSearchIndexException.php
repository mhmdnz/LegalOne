<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Psr\Log\LoggerInterface;

class ElasticSearchIndexException extends Exception
{
    private static $logger = null;

    /**
     * Set the logger instance.
     *
     * @param LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger): void
    {
        self::$logger = $logger;
    }

    public static function checkAndThrow(Throwable $originalException): void
    {
        $message = $originalException->getMessage();
        $decodedMessage = json_decode($message, true);

        self::logToFile($originalException);

        if (
            isset($decodedMessage['error']['type']) &&
            $decodedMessage['error']['type'] === 'index_not_found_exception'
        ) {
            throw new self($message, $originalException->getCode(), $originalException);
        }
    }

    private static function logToFile(Throwable $originalException): void
    {
        if (self::$logger) {
            self::$logger->error('Exception occurred: ' . $originalException->getMessage(), [
                'exception' => $originalException,
            ]);
        }
    }
}