<?php

namespace App\Math;

interface CalculatorInterface
{

    public function calculate(int $a, int $b): string;
}