<?php

namespace Tests\Feature\Modules\LogStatisticsModule;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TruncateElasticSearchDatabaseControllerTest extends WebTestCase
{
    public function testDeleteElasticSearchIndices()
    {
        // Arrange
        $client = static::createClient();

        // Act
        $client->request('DELETE', '/delete');

        // Assert
        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}