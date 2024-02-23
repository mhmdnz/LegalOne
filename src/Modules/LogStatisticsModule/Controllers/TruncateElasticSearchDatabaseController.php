<?php

namespace App\Modules\LogStatisticsModule\Controllers;

use App\Modules\LogStatisticsModule\Interfaces\TruncateElasticSearchDatabaseActionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TruncateElasticSearchDatabaseController extends AbstractController
{
    public function __construct(
        private TruncateElasticSearchDatabaseActionInterface $truncateElasticSearchDatabaseAction
    ) {
    }

    /**
     * @Route("/delete", name="elasticsearch_truncate", methods={"DELETE"})
     */
    public function count(): Response
    {
        ($this->truncateElasticSearchDatabaseAction)();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}