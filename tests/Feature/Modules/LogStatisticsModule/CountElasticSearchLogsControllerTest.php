<?php

namespace Tests\Feature\Modules\LogStatisticsModule;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CountElasticSearchLogsControllerTest extends WebTestCase
{
    public function testCountWithoutParameters()
    {
        //Arrange
        $requestParameters = '/count';
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testCountWithParameters()
    {
        //Arrange
        $requestParameters = '/count?serviceNames=USER-SERVICE&serviceNames=Invoice&startDate=2018-08-01 10:10:10&endDate=2019-01-01 10:10:10&statusCode=200';
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testRequestMethod()
    {
        //Arrange
        $requestParameters = '/count';
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('POST', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $client->getResponse()->getStatusCode());
    }

    public function testCountWithValidServiceNames()
    {
        //Arrange
        $requestParameters = '/count?serviceNames=service1&serviceNames=service2';
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testCountWithOneServiceNames()
    {
        //Arrange
        $requestParameters = '/count?serviceNames=service1';
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testCountWithStatusCode()
    {
        //Arrange
        $requestParameters = '/count?statusCode=200';
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testCountWithInvalidStatusCode()
    {
        //Arrange
        $requestParameters = '/count?statusCode=character';
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testCountWithStartDate()
    {
        //Arrange
        $requestParameters = '/count?startDate=2018-08-01 10:10:10';
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testCountWithStartDateValidationError()
    {
        //Arrange
        $requestParameters = '/count?startDate=2018-08-01';//Wrong Format
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testCountWithEndDate()
    {
        //Arrange
        $requestParameters = '/count?startDate=2018-08-01 10:10:10';
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testCountWithEndDateValidationError()
    {
        //Arrange
        $requestParameters = '/count?endDate=2018-08-01';//Wrong Format
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testCountWithStartDateBiggerThanEndDate()
    {
        //Arrange
        $requestParameters = '/count?startDate=2019-08-01&endDate=2018-08-01';//Wrong Format
        $_SERVER['QUERY_STRING'] = $requestParameters;
        $client = static::createClient();

        //ACT
        $client->request('GET', $requestParameters);

        //Assert
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}