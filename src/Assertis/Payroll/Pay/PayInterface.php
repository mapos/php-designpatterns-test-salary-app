<?php
namespace Assertis\Payroll\Pay;

use DateTime;

/**
 * Interface for salary and bonus calculators
 * @package Assertis\Payroll
 */
interface PayInterface
{
    /**
     * {@inheritdoc}
     */
    public function get(DateTime $date);
}
