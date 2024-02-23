<?php

namespace App\Modules\LogStatisticsModule\DTOs;

class GetLogCountsDTO
{
    public function __construct(
        public int $count = 0,
    ) {
    }
}