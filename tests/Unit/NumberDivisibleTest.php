<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class NumberDivisibleTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_number_divisible_by_36()
    {
        $number = 108;

        $this->assertTrue($number % 36 === 0);
    }
}
