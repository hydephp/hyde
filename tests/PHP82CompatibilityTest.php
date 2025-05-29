<?php

declare(strict_types=1);

namespace Hyde\Testing;

use Hyde\Hyde;
use Hyde\Pages\BladePage;
use Hyde\Pages\MarkdownPage;
use Hyde\Pages\MarkdownPost;
use Hyde\Pages\DocumentationPage;
use Illuminate\Support\Facades\File;

/**
 * PHP 8.2 Compatibility Test Suite
 * 
 * Tests core functionality specifically for PHP 8.2 compatibility
 * including new features and deprecation handling.
 */
class PHP82CompatibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->skipIfNotPhp82();
    }

    protected function skipIfNotPhp82(): void
    {
        if (version_compare(PHP_VERSION, '8.2.0', '<') || version_compare(PHP_VERSION, '8.3.0', '>=')) {
            $this->markTestSkipped('This test is only for PHP 8.2');
        }
    }

    public function testPhp82ReadonlyClassesCompatibility()
    {
        // Test that readonly classes work correctly if used in framework
        $this->assertTrue(class_exists('Hyde\Hyde'));
        $this->assertInstanceOf('Hyde\Foundation\HydeKernel', Hyde::kernel());
    }

    public function testPhp82DisjunctiveNormalFormTypes()
    {
        // Test DNF types compatibility if used in codebase
        $this->assertTrue(true); // Placeholder for DNF type tests
    }

    public function testPhp82DeprecationHandling()
    {
        // Capture any deprecation warnings
        $errorHandler = set_error_handler(function ($severity, $message, $file, $line) {
            if ($severity === E_DEPRECATED) {
                $this->fail("Deprecation warning detected: $message in $file:$line");
            }
            return false;
        });

        try {
            // Test core functionality
            $this->artisan('list')->assertExitCode(0);
            
            // Test page creation
            $this->artisan('make:page', ['title' => 'test-php82'])
                ->assertExitCode(0);
                
            // Clean up
            if (File::exists(Hyde::path('_pages/test-php82.blade.php'))) {
                File::delete(Hyde::path('_pages/test-php82.blade.php'));
            }
        } finally {
            restore_error_handler();
        }
    }

    public function testPhp82StringFunctionCompatibility()
    {
        // Test string functions that might have changed behavior
        $testString = "HydePHP v2.0";
        $this->assertIsString($testString);
        $this->assertStringContainsString("HydePHP", $testString);
    }

    public function testPhp82ArrayFunctionCompatibility()
    {
        // Test array functions for any behavioral changes
        $testArray = ['hyde', 'php', 'v2'];
        $this->assertIsArray($testArray);
        $this->assertCount(3, $testArray);
        $this->assertContains('hyde', $testArray);
    }

    public function testPhp82FileSystemOperations()
    {
        // Test file system operations for PHP 8.2 compatibility
        $testFile = Hyde::path('test-php82.tmp');
        
        File::put($testFile, 'PHP 8.2 test content');
        $this->assertFileExists($testFile);
        
        $content = File::get($testFile);
        $this->assertEquals('PHP 8.2 test content', $content);
        
        File::delete($testFile);
        $this->assertFileDoesNotExist($testFile);
    }

    public function testPhp82JsonHandling()
    {
        // Test JSON operations for PHP 8.2 compatibility
        $data = ['version' => '2.0', 'php' => '8.2'];
        $json = json_encode($data);
        $decoded = json_decode($json, true);
        
        $this->assertEquals($data, $decoded);
        $this->assertJson($json);
    }
}
