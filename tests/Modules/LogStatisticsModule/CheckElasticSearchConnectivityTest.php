<?php

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Elasticsearch\Client;

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