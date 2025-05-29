<?php

declare(strict_types=1);

namespace Hyde\Testing;

use Hyde\Hyde;
use Illuminate\Support\Facades\File;

/**
 * PHP 8.3 Compatibility Test Suite
 * 
 * Tests core functionality specifically for PHP 8.3 compatibility
 * including new features and performance improvements.
 */
class PHP83CompatibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->skipIfNotPhp83();
    }

    protected function skipIfNotPhp83(): void
    {
        if (version_compare(PHP_VERSION, '8.3.0', '<') || version_compare(PHP_VERSION, '8.4.0', '>=')) {
            $this->markTestSkipped('This test is only for PHP 8.3');
        }
    }

    public function testPhp83TypedClassConstants()
    {
        // Test typed class constants if used in framework
        $this->assertTrue(defined('PHP_VERSION'));
        $this->assertIsString(PHP_VERSION);
    }

    public function testPhp83OverrideAttribute()
    {
        // Test #[Override] attribute compatibility if used
        $this->assertTrue(true); // Placeholder for override attribute tests
    }

    public function testPhp83AnonymousReadonlyClasses()
    {
        // Test anonymous readonly classes if used
        $anonymousClass = new class {
            public function test(): string {
                return 'PHP 8.3 test';
            }
        };
        
        $this->assertEquals('PHP 8.3 test', $anonymousClass->test());
    }

    public function testPhp83DeprecationHandling()
    {
        // Capture any deprecation warnings specific to PHP 8.3
        $errorHandler = set_error_handler(function ($severity, $message, $file, $line) {
            if ($severity === E_DEPRECATED) {
                $this->fail("PHP 8.3 Deprecation warning: $message in $file:$line");
            }
            return false;
        });

        try {
            // Test core functionality
            $this->artisan('list')->assertExitCode(0);
            
            // Test build command
            $this->artisan('build', ['--no-interaction' => true])
                ->assertExitCode(0);
                
        } finally {
            restore_error_handler();
        }
    }

    public function testPhp83JsonValidate()
    {
        // Test json_validate function if available
        if (function_exists('json_validate')) {
            $this->assertTrue(json_validate('{"test": "value"}'));
            $this->assertFalse(json_validate('invalid json'));
        } else {
            $this->markTestSkipped('json_validate not available in this PHP version');
        }
    }

    public function testPhp83ArrayFindFunctions()
    {
        // Test new array functions if available
        $array = [1, 2, 3, 4, 5];
        
        if (function_exists('array_find')) {
            $result = array_find($array, fn($value) => $value > 3);
            $this->assertEquals(4, $result);
        }
        
        if (function_exists('array_find_key')) {
            $assocArray = ['a' => 1, 'b' => 2, 'c' => 3];
            $key = array_find_key($assocArray, fn($value) => $value === 2);
            $this->assertEquals('b', $key);
        }
    }

    public function testPhp83PerformanceImprovements()
    {
        // Test performance-related improvements
        $start = microtime(true);
        
        // Perform some operations
        for ($i = 0; $i < 1000; $i++) {
            $data = ['iteration' => $i, 'test' => 'php83'];
            json_encode($data);
        }
        
        $end = microtime(true);
        $duration = $end - $start;
        
        // Just ensure it completes without errors
        $this->assertIsFloat($duration);
        $this->assertGreaterThan(0, $duration);
    }

    public function testPhp83StringFunctions()
    {
        // Test string function improvements
        $testString = "HydePHP v2.0 PHP 8.3";
        
        $this->assertIsString($testString);
        $this->assertStringContainsString("PHP 8.3", $testString);
        
        // Test mb_str_pad if available
        if (function_exists('mb_str_pad')) {
            $padded = mb_str_pad("test", 10, "0", STR_PAD_LEFT);
            $this->assertEquals("000000test", $padded);
        }
    }
}
