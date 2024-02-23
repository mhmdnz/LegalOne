<?php

namespace App\Modules\LogStatisticsModule\Interfaces;

interface TruncateElasticSearchDatabaseServiceInterface
{
    public function __invoke(): bool;
}