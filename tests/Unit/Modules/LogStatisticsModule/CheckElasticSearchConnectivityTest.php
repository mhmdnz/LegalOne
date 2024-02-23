<?php

namespace Tests\Unit\Modules\LogStatisticsModule;

use Elasticsearch\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CheckElasticSearchConnectivityTest extends KernelTestCase
{
    public function testElasticSearchConnection()
    {
        //Arrange
        $client = self::getContainer()->get(Client::class);

        //Act
        $response = $client->info();

        //Assert
        $this->assertIsArray($response);
        $this->assertArrayHasKey('version', $response);
    }
}