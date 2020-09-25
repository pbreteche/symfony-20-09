<?php

namespace App\Math;

use Psr\Log\LoggerInterface;

class Adder
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function calculate(int $a, int $b)
    {
        $this->logger->debug('Addition de '.$a.' et '.$b);
        return $a + $b;
    }
}