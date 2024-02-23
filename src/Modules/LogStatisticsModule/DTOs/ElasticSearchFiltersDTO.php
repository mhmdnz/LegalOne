<?php

namespace App\Modules\LogStatisticsModule\DTOs;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ElasticSearchFiltersDTO
{
    /**
     * @Assert\All({
     *     @Assert\Type("string")
     * })
     */
    public $serviceNames = [];

    /**
     * @Assert\DateTime()
     */
    public $startDate;

    /**
     * @Assert\DateTime()
     */
    public $endDate;

    /**
     * @Assert\Type("integer")
     * @Assert\Range(min=100, max=599)
     */
    public $statusCode;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->startDate && $this->endDate) {
            $startDate = $this->startDate instanceof \DateTime ? $this->startDate : new \DateTime($this->startDate);
            $endDate = $this->endDate instanceof \DateTime ? $this->endDate : new \DateTime($this->endDate);

            if ($startDate >= $endDate) {
                $context->buildViolation('The end date must be greater than the start date.')
                    ->atPath('endDate')
                    ->addViolation();
            }
        }
    }
}