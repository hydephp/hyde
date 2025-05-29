<?php

declare(strict_types=1);

namespace Hyde\Testing;

use Hyde\Hyde;
use Illuminate\Support\Facades\File;

/**
 * Performance Test Suite
 * 
 * Tests performance characteristics across different PHP versions
 * and identifies potential performance regressions.
 */
class PerformanceTest extends TestCase
{
    protected array $performanceMetrics = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->performanceMetrics = [];
    }

    protected function tearDown(): void
    {
        $this->cleanupTestFiles();
        $this->reportPerformanceMetrics();
        parent::tearDown();
    }

    protected function cleanupTestFiles(): void
    {
        $testFiles = [
            '_pages/perf-test-*.blade.php',
            '_pages/perf-test-*.md',
            '_posts/perf-test-*.md',
            '_docs/perf-test-*.md',
            '_site'
        ];

        foreach ($testFiles as $pattern) {
            $files = glob(Hyde::path($pattern));
            foreach ($files as $file) {
                if (File::exists($file)) {
                    if (File::isDirectory($file)) {
                        File::deleteDirectory($file);
                    } else {
                        File::delete($file);
                    }
                }
            }
        }
    }

    protected function measureExecutionTime(string $operation, callable $callback): float
    {
        $start = microtime(true);
        $callback();
        $end = microtime(true);
        
        $duration = $end - $start;
        $this->performanceMetrics[$operation] = $duration;
        
        return $duration;
    }

    protected function reportPerformanceMetrics(): void
    {
        if (empty($this->performanceMetrics)) {
            return;
        }

        echo "\n=== Performance Metrics (PHP " . PHP_VERSION . ") ===\n";
        foreach ($this->performanceMetrics as $operation => $duration) {
            echo sprintf("%-30s: %.4f seconds\n", $operation, $duration);
        }
        echo "================================================\n";
    }

    public function testSinglePageBuildPerformance()
    {
        // Create a test page
        File::put(Hyde::path('_pages/perf-test-single.blade.php'), 
            '@extends("hyde::layouts.app")
            @section("content")
            <h1>Performance Test Page</h1>
            <p>This is a test page for performance measurement.</p>
            @endsection'
        );

        $duration = $this->measureExecutionTime('Single Page Build', function () {
            $this->artisan('build', ['--no-interaction' => true])
                ->assertExitCode(0);
        });

        // Assert reasonable performance (adjust threshold as needed)
        $this->assertLessThan(30.0, $duration, 'Single page build took too long');
        $this->assertFileExists(Hyde::path('_site/perf-test-single.html'));
    }

    public function testMultiplePagesBuildPerformance()
    {
        // Create multiple test pages
        for ($i = 1; $i <= 10; $i++) {
            File::put(Hyde::path("_pages/perf-test-multi-{$i}.blade.php"), 
                "@extends('hyde::layouts.app')
                @section('content')
                <h1>Performance Test Page {$i}</h1>
                <p>This is test page number {$i} for performance measurement.</p>
                @endsection"
            );
        }

        $duration = $this->measureExecutionTime('Multiple Pages Build (10 pages)', function () {
            $this->artisan('build', ['--no-interaction' => true])
                ->assertExitCode(0);
        });

        // Assert reasonable performance
        $this->assertLessThan(60.0, $duration, 'Multiple pages build took too long');
        
        // Verify all pages were built
        for ($i = 1; $i <= 10; $i++) {
            $this->assertFileExists(Hyde::path("_site/perf-test-multi-{$i}.html"));
        }
    }

    public function testLargeMarkdownFileProcessing()
    {
        // Create a large markdown file
        $largeContent = "# Large Markdown Test\n\n";
        for ($i = 1; $i <= 100; $i++) {
            $largeContent .= "## Section {$i}\n\n";
            $largeContent .= str_repeat("This is paragraph {$i} with some content to make it longer. ", 10) . "\n\n";
            $largeContent .= "```php\n<?php\necho 'Code block {$i}';\n```\n\n";
        }

        File::put(Hyde::path('_pages/perf-test-large.md'), $largeContent);

        $duration = $this->measureExecutionTime('Large Markdown Processing', function () {
            $this->artisan('build', ['--no-interaction' => true])
                ->assertExitCode(0);
        });

        $this->assertLessThan(45.0, $duration, 'Large markdown processing took too long');
        $this->assertFileExists(Hyde::path('_site/perf-test-large.html'));
    }

    public function testMemoryUsageDuringBuild()
    {
        $memoryBefore = memory_get_usage(true);
        $peakBefore = memory_get_peak_usage(true);

        // Create several test files
        for ($i = 1; $i <= 5; $i++) {
            File::put(Hyde::path("_posts/perf-test-post-{$i}.md"), 
                "---\ntitle: Performance Test Post {$i}\ndate: 2024-01-01\n---\n\n# Test Post {$i}\n\nContent for post {$i}."
            );
        }

        $this->artisan('build', ['--no-interaction' => true])
            ->assertExitCode(0);

        $memoryAfter = memory_get_usage(true);
        $peakAfter = memory_get_peak_usage(true);

        $memoryIncrease = $memoryAfter - $memoryBefore;
        $peakIncrease = $peakAfter - $peakBefore;

        // Log memory usage
        $this->performanceMetrics['Memory Increase'] = $memoryIncrease / 1024 / 1024; // MB
        $this->performanceMetrics['Peak Memory Increase'] = $peakIncrease / 1024 / 1024; // MB

        // Assert reasonable memory usage (adjust thresholds as needed)
        $this->assertLessThan(100 * 1024 * 1024, $memoryIncrease, 'Memory usage increased too much'); // 100MB
        $this->assertLessThan(200 * 1024 * 1024, $peakIncrease, 'Peak memory usage too high'); // 200MB
    }

    public function testCommandResponseTime()
    {
        $commands = [
            'list',
            'about',
            'build --help',
            'make:page --help',
            'make:post --help'
        ];

        foreach ($commands as $command) {
            $duration = $this->measureExecutionTime("Command: {$command}", function () use ($command) {
                $this->artisan($command)->assertExitCode(0);
            });

            $this->assertLessThan(5.0, $duration, "Command '{$command}' took too long to respond");
        }
    }

    public function testConcurrentOperations()
    {
        // Test multiple operations in sequence to simulate concurrent usage
        $operations = [
            function () {
                File::put(Hyde::path('_pages/perf-concurrent-1.md'), '# Concurrent Test 1');
            },
            function () {
                File::put(Hyde::path('_pages/perf-concurrent-2.md'), '# Concurrent Test 2');
            },
            function () {
                File::put(Hyde::path('_posts/perf-concurrent-post.md'), 
                    "---\ntitle: Concurrent Post\ndate: 2024-01-01\n---\n\n# Concurrent Post"
                );
            }
        ];

        $duration = $this->measureExecutionTime('Concurrent File Operations', function () use ($operations) {
            foreach ($operations as $operation) {
                $operation();
            }
            
            $this->artisan('build', ['--no-interaction' => true])
                ->assertExitCode(0);
        });

        $this->assertLessThan(30.0, $duration, 'Concurrent operations took too long');
    }
}
