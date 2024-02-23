<?php

namespace App\Modules\LogStatisticsModule\Controllers;

use App\Modules\LogStatisticsModule\DTOs\ElasticSearchFiltersDTO;
use App\Modules\LogStatisticsModule\Interfaces\GetLogCountsByGivenFilterActionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CountElasticSearchLogsController extends AbstractController
{
    public function __construct(
        private ValidatorInterface $validator,
        private GetLogCountsByGivenFilterActionInterface $getLogCountsByGivenFilterAction
    ) {
    }

    /**
     * @Route("/count", name="elasticsearch_log_count", methods={"GET"})
     */
    public function count(Request $request): Response
    {
        $elasticSearchFilterDTO = $this->getElasticSearchFilterDTO($request);

        $errors = $this->validator->validate($elasticSearchFilterDTO);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString, Response::HTTP_BAD_REQUEST);
        }

        return $this->json(($this->getLogCountsByGivenFilterAction)($elasticSearchFilterDTO));
    }

    private function getElasticSearchFilterDTO(Request $request): ElasticSearchFiltersDTO
    {
        $statusCode = $request->query->get('statusCode');
        $elasticSearchFiltersDTO = new ElasticSearchFiltersDTO();
        $elasticSearchFiltersDTO->serviceNames = $this->getMultiValueArgument('serviceNames');
        $elasticSearchFiltersDTO->startDate = $request->query->get('startDate');
        $elasticSearchFiltersDTO->endDate = $request->query->get('endDate');
        $elasticSearchFiltersDTO->statusCode = is_numeric($statusCode) ? (int)$statusCode : $statusCode;

        return $elasticSearchFiltersDTO;
    }

    private function getMultiValueArgument(String $fieldName): array
    {
        $result = [];
        $query  = explode('&', $_SERVER['QUERY_STRING']);
        foreach ($query as $parameter) {
            if (str_starts_with($parameter, "$fieldName=")) {
                $parameterName = substr($parameter, strlen("$fieldName="));
                $result[] = $parameterName;
            }
        }

        return $result;
    }
}