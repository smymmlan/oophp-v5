<?php

namespace Tuss\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class HistogramTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testCreateObjectHistogram()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("\Tuss\Dice100\Histogram", $histogram);
    }
}
