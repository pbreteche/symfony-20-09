<?php

namespace App\Math;

use Psr\Log\LoggerInterface;

class Adder implements CalculatorInterface
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    /**
     * @var string
     */
    private $unit;

    public function __construct(LoggerInterface $logger, string $unit)
    {
        $this->logger = $logger;
        $this->unit = $unit;
    }

    public function calculate(int $a, int $b): string
    {
        $this->logger->debug('Addition de '.$a.' et '.$b);
        return ($a + $b).$this->unit;
    }
}