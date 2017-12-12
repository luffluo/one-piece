<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FunctionsTest extends TestCase
{
    /**
     * @return void
     */
    public function testOption()
    {
        $actual = option('provinces');

        $expected = null;
        $this->assertSame($expected, $actual);
    }
}
