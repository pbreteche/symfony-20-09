<?php

namespace App\Math;

use Psr\Log\LoggerInterface;

class Adder
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

    public function calculate(int $a, int $b)
    {
        $this->logger->debug('Addition de '.$a.' et '.$b);
        return ($a + $b).$this->unit;
    }
}