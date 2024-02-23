<?php

namespace App\Modules\LogStatisticsModule\Interfaces;

interface TruncateElasticSearchDatabaseActionInterface
{
    public function __invoke(): bool;
}