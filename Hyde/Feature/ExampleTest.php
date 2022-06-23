<?php

namespace Hyde\Testing\Hyde\Feature;

use Hyde\Testing\TestCase;

class ExampleTest extends TestCase
{
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_helpers_are_available()
    {
        $this->assertTrue(function_exists('backup'));
    }
}
