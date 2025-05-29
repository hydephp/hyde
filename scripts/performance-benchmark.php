#!/usr/bin/env php
<?php

/**
 * HydePHP v2.0 Performance Benchmarking Script
 * 
 * Measures performance across different PHP versions
 * and generates detailed performance reports.
 */

declare(strict_types=1);

class HydePerformanceBenchmark
{
    private array $results = [];
    private string $baseDir;
    private int $iterations = 3;
    
    public function __construct()
    {
        $this->baseDir = dirname(__DIR__);
        echo "⚡ HydePHP v2.0 Performance Benchmark\n";
        echo "====================================\n\n";
    }
    
    public function runBenchmarks(): void
    {
        echo "🔥 Starting performance benchmarks...\n\n";
        
        $benchmarks = [
            'build_performance' => 'Build Process Performance',
            'cli_responsiveness' => 'CLI Command Responsiveness',
            'memory_usage' => 'Memory Usage Analysis',
            'file_generation' => 'File Generation Speed',
            'asset_compilation' => 'Asset Compilation Speed'
        ];
        
        foreach ($benchmarks as $method => $description) {
            echo "📊 Running: {$description}\n";
            $this->results[$method] = $this->$method();
            echo "✅ Completed: {$description}\n\n";
        }
        
        $this->generatePerformanceReport();
    }
    
    private function build_performance(): array
    {
        $times = [];
        $memoryUsage = [];
        
        for ($i = 0; $i < $this->iterations; $i++) {
            echo "  🔄 Build iteration " . ($i + 1) . "/{$this->iterations}\n";
            
            $start = microtime(true);
            $startMemory = memory_get_usage(true);
            
            $output = shell_exec("./php/php.exe hyde build --no-interaction 2>&1");
            
            $endMemory = memory_get_peak_usage(true);
            $duration = microtime(true) - $start;
            
            $times[] = $duration;
            $memoryUsage[] = $endMemory - $startMemory;
            
            // Extract build time from output if available
            if (preg_match('/Finished in ([\d.]+) seconds/', $output, $matches)) {
                $reportedTime = (float) $matches[1];
                echo "    ⏱️  Reported build time: {$reportedTime}s\n";
            }
            
            echo "    ⏱️  Measured time: " . number_format($duration, 2) . "s\n";
            echo "    💾 Memory delta: " . $this->formatBytes($endMemory - $startMemory) . "\n";
        }
        
        return [
            'average_time' => array_sum($times) / count($times),
            'min_time' => min($times),
            'max_time' => max($times),
            'times' => $times,
            'average_memory' => array_sum($memoryUsage) / count($memoryUsage),
            'memory_usage' => $memoryUsage
        ];
    }
    
    private function cli_responsiveness(): array
    {
        $commands = [
            'version' => './php/php.exe hyde --version',
            'list' => './php/php.exe hyde list',
            'validate' => './php/php.exe hyde validate'
        ];
        
        $results = [];
        
        foreach ($commands as $name => $command) {
            $times = [];
            
            for ($i = 0; $i < $this->iterations; $i++) {
                $start = microtime(true);
                shell_exec($command . " 2>&1");
                $times[] = microtime(true) - $start;
            }
            
            $results[$name] = [
                'average' => array_sum($times) / count($times),
                'min' => min($times),
                'max' => max($times)
            ];
            
            echo "  📋 {$name}: " . number_format($results[$name]['average'], 3) . "s avg\n";
        }
        
        return $results;
    }
    
    private function memory_usage(): array
    {
        $start = microtime(true);
        $startMemory = memory_get_usage(true);
        $startPeak = memory_get_peak_usage(true);
        
        // Run a comprehensive build
        $output = shell_exec("./php/php.exe hyde build --no-interaction 2>&1");
        
        $endMemory = memory_get_usage(true);
        $endPeak = memory_get_peak_usage(true);
        $duration = microtime(true) - $start;
        
        // Extract memory info from output if available
        $reportedMemory = null;
        if (preg_match('/([\d.]+)MB peak memory usage/', $output, $matches)) {
            $reportedMemory = (float) $matches[1];
        }
        
        return [
            'start_memory' => $startMemory,
            'end_memory' => $endMemory,
            'peak_memory' => $endPeak,
            'memory_delta' => $endMemory - $startMemory,
            'peak_delta' => $endPeak - $startPeak,
            'reported_peak_mb' => $reportedMemory,
            'duration' => $duration
        ];
    }
    
    private function file_generation(): array
    {
        // Test individual page generation speed
        $pageTypes = [
            'blade' => './php/php.exe hyde make:page "Perf Test Blade" --type=blade --no-interaction',
            'markdown' => './php/php.exe hyde make:page "Perf Test MD" --type=markdown --no-interaction',
            'docs' => './php/php.exe hyde make:page "Perf Test Docs" --type=docs --no-interaction'
        ];
        
        $results = [];
        
        foreach ($pageTypes as $type => $command) {
            $times = [];
            
            for ($i = 0; $i < $this->iterations; $i++) {
                $start = microtime(true);
                shell_exec($command . " 2>&1");
                $times[] = microtime(true) - $start;
            }
            
            $results[$type] = [
                'average' => array_sum($times) / count($times),
                'min' => min($times),
                'max' => max($times)
            ];
            
            echo "  📄 {$type}: " . number_format($results[$type]['average'], 3) . "s avg\n";
        }
        
        return $results;
    }
    
    private function asset_compilation(): array
    {
        $start = microtime(true);
        
        // Check if assets are compiled during build
        $output = shell_exec("./php/php.exe hyde build --no-interaction 2>&1");
        
        $duration = microtime(true) - $start;
        
        // Check generated assets
        $assetsGenerated = [
            'css' => file_exists($this->baseDir . '/_site/media/app.css'),
            'site_files' => is_dir($this->baseDir . '/_site'),
            'pages' => count(glob($this->baseDir . '/_site/*.html')),
            'posts' => count(glob($this->baseDir . '/_site/posts/*.html')),
            'docs' => count(glob($this->baseDir . '/_site/docs/*.html'))
        ];
        
        return [
            'compilation_time' => $duration,
            'assets_generated' => $assetsGenerated,
            'total_files' => array_sum(array_filter($assetsGenerated, 'is_numeric'))
        ];
    }
    
    private function generatePerformanceReport(): void
    {
        echo "\n📊 PERFORMANCE BENCHMARK RESULTS\n";
        echo "=================================\n\n";
        
        // Build Performance Summary
        $build = $this->results['build_performance'];
        echo "🏗️  BUILD PERFORMANCE:\n";
        echo "   Average: " . number_format($build['average_time'], 2) . "s\n";
        echo "   Range: " . number_format($build['min_time'], 2) . "s - " . number_format($build['max_time'], 2) . "s\n";
        echo "   Memory: " . $this->formatBytes($build['average_memory']) . " avg\n\n";
        
        // CLI Responsiveness
        echo "⚡ CLI RESPONSIVENESS:\n";
        foreach ($this->results['cli_responsiveness'] as $cmd => $data) {
            echo "   {$cmd}: " . number_format($data['average'], 3) . "s\n";
        }
        echo "\n";
        
        // Memory Usage
        $memory = $this->results['memory_usage'];
        echo "💾 MEMORY USAGE:\n";
        echo "   Peak: " . $this->formatBytes($memory['peak_memory']) . "\n";
        echo "   Delta: " . $this->formatBytes($memory['memory_delta']) . "\n";
        if ($memory['reported_peak_mb']) {
            echo "   Reported: {$memory['reported_peak_mb']}MB\n";
        }
        echo "\n";
        
        // File Generation
        echo "📄 FILE GENERATION:\n";
        foreach ($this->results['file_generation'] as $type => $data) {
            echo "   {$type}: " . number_format($data['average'], 3) . "s\n";
        }
        echo "\n";
        
        // Asset Compilation
        $assets = $this->results['asset_compilation'];
        echo "🎨 ASSET COMPILATION:\n";
        echo "   Time: " . number_format($assets['compilation_time'], 2) . "s\n";
        echo "   Files: {$assets['total_files']} generated\n";
        echo "   CSS: " . ($assets['assets_generated']['css'] ? '✅' : '❌') . "\n\n";
        
        $this->savePerformanceReport();
    }
    
    private function savePerformanceReport(): void
    {
        $reportData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'php_version' => PHP_VERSION,
            'hydephp_version' => '2.0.0-RC.2',
            'iterations' => $this->iterations,
            'system_info' => [
                'os' => PHP_OS,
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time')
            ],
            'results' => $this->results
        ];
        
        $filename = 'performance-report-' . date('Y-m-d-H-i-s') . '.json';
        file_put_contents($filename, json_encode($reportData, JSON_PRETTY_PRINT));
        
        echo "📄 Performance report saved to: {$filename}\n";
        
        // Also create a CSV summary
        $this->createCsvSummary($reportData);
    }
    
    private function createCsvSummary(array $data): void
    {
        $csv = "Metric,Value,Unit\n";
        $csv .= "PHP Version,{$data['php_version']},\n";
        $csv .= "Average Build Time," . number_format($data['results']['build_performance']['average_time'], 2) . ",seconds\n";
        $csv .= "Min Build Time," . number_format($data['results']['build_performance']['min_time'], 2) . ",seconds\n";
        $csv .= "Max Build Time," . number_format($data['results']['build_performance']['max_time'], 2) . ",seconds\n";
        $csv .= "Peak Memory," . $data['results']['memory_usage']['peak_memory'] . ",bytes\n";
        $csv .= "Files Generated," . $data['results']['asset_compilation']['total_files'] . ",count\n";
        
        foreach ($data['results']['cli_responsiveness'] as $cmd => $cmdData) {
            $csv .= "CLI {$cmd}," . number_format($cmdData['average'], 3) . ",seconds\n";
        }
        
        $filename = 'performance-summary-' . date('Y-m-d-H-i-s') . '.csv';
        file_put_contents($filename, $csv);
        
        echo "📊 CSV summary saved to: {$filename}\n";
    }
    
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}

// Main execution
if (php_sapi_name() === 'cli') {
    $benchmark = new HydePerformanceBenchmark();
    $benchmark->runBenchmarks();
}
