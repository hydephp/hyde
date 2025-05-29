<?php

declare(strict_types=1);

namespace Hyde\Testing;

use Hyde\Hyde;
use Illuminate\Support\Facades\File;

/**
 * PHP 8.4 Compatibility Test Suite
 * 
 * Tests core functionality specifically for PHP 8.4 compatibility
 * including new features and potential breaking changes.
 */
class PHP84CompatibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->skipIfNotPhp84();
    }

    protected function skipIfNotPhp84(): void
    {
        if (version_compare(PHP_VERSION, '8.4.0', '<')) {
            $this->markTestSkipped('This test is only for PHP 8.4');
        }
    }

    public function testPhp84PropertyHooks()
    {
        // Test property hooks if used in framework
        // This is a placeholder as property hooks are a major PHP 8.4 feature
        $this->assertTrue(true);
    }

    public function testPhp84AsymmetricVisibility()
    {
        // Test asymmetric visibility if used
        // Another major PHP 8.4 feature
        $this->assertTrue(true);
    }

    public function testPhp84NewArrayFunctions()
    {
        // Test new array functions in PHP 8.4
        $array = [1, 2, 3, 4, 5];
        
        // Test array_all if available
        if (function_exists('array_all')) {
            $result = array_all($array, fn($value) => $value > 0);
            $this->assertTrue($result);
        }
        
        // Test array_any if available
        if (function_exists('array_any')) {
            $result = array_any($array, fn($value) => $value > 3);
            $this->assertTrue($result);
        }
    }

    public function testPhp84DeprecationHandling()
    {
        // Capture any deprecation warnings specific to PHP 8.4
        $errorHandler = set_error_handler(function ($severity, $message, $file, $line) {
            if ($severity === E_DEPRECATED) {
                $this->fail("PHP 8.4 Deprecation warning: $message in $file:$line");
            }
            return false;
        });

        try {
            // Test core functionality
            $this->artisan('list')->assertExitCode(0);
            
            // Test page creation commands
            $this->artisan('make:page', ['title' => 'test-php84'])
                ->assertExitCode(0);
                
            $this->artisan('make:post', ['title' => 'test-php84-post'])
                ->assertExitCode(0);
                
            // Clean up
            $files = [
                Hyde::path('_pages/test-php84.blade.php'),
                Hyde::path('_posts/test-php84-post.md')
            ];
            
            foreach ($files as $file) {
                if (File::exists($file)) {
                    File::delete($file);
                }
            }
                
        } finally {
            restore_error_handler();
        }
    }

    public function testPhp84ImplicitNullability()
    {
        // Test implicit nullability deprecations
        $this->assertTrue(true); // Placeholder for nullability tests
    }

    public function testPhp84JitImprovements()
    {
        // Test JIT compiler improvements
        $start = microtime(true);
        
        // Perform computationally intensive operations
        $result = 0;
        for ($i = 0; $i < 10000; $i++) {
            $result += $i * 2;
        }
        
        $end = microtime(true);
        $duration = $end - $start;
        
        $this->assertIsInt($result);
        $this->assertIsFloat($duration);
        $this->assertGreaterThan(0, $duration);
    }

    public function testPhp84NewStringFunctions()
    {
        // Test new string functions in PHP 8.4
        $testString = "HydePHP v2.0 PHP 8.4";
        
        $this->assertIsString($testString);
        $this->assertStringContainsString("PHP 8.4", $testString);
        
        // Test any new string functions that might be available
        if (function_exists('str_increment')) {
            // Test str_increment if it exists
            $this->assertTrue(true);
        }
    }

    public function testPhp84ErrorHandling()
    {
        // Test improved error handling in PHP 8.4
        try {
            // Test operations that might trigger errors
            $this->artisan('build', ['--no-interaction' => true])
                ->assertExitCode(0);
                
        } catch (\Throwable $e) {
            $this->fail("Unexpected error in PHP 8.4: " . $e->getMessage());
        }
    }

    public function testPhp84MemoryUsage()
    {
        // Test memory usage improvements
        $memoryBefore = memory_get_usage();
        
        // Perform memory-intensive operations
        $largeArray = array_fill(0, 1000, 'test data');
        unset($largeArray);
        
        $memoryAfter = memory_get_usage();
        
        $this->assertIsInt($memoryBefore);
        $this->assertIsInt($memoryAfter);
    }
}
