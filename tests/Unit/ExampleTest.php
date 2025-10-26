<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    #[Test]
    public function math_still_works(): void
    {
        $x = random_int(1, 9);
        $this->assertSame($x, ($x + 2) - 2);
    }
}
