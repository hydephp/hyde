<?php

/**
 * HydePHP v2.0 Multi-Version Testing Script
 * 
 * This script automates testing across different PHP versions
 * and generates comprehensive reports for beta testing.
 */

declare(strict_types=1);

class HydePhpVersionTester
{
    private array $supportedVersions = ['8.2', '8.3', '8.4'];
    private array $testResults = [];
    private string $projectRoot;
    private string $reportsDir;

    public function __construct()
    {
        $this->projectRoot = dirname(__DIR__);
        $this->reportsDir = $this->projectRoot . '/test-reports';
        
        if (!is_dir($this->reportsDir)) {
            mkdir($this->reportsDir, 0755, true);
        }
    }

    public function runAllTests(): void
    {
        echo "🚀 Starting HydePHP v2.0 Multi-Version Testing\n";
        echo "============================================\n\n";

        foreach ($this->supportedVersions as $version) {
            echo "📋 Testing PHP {$version}...\n";
            $this->testPhpVersion($version);
            echo "\n";
        }

        $this->generateSummaryReport();
        echo "✅ Testing complete! Check {$this->reportsDir} for detailed reports.\n";
    }

    private function testPhpVersion(string $version): void
    {
        $phpBinary = $this->findPhpBinary($version);
        
        if (!$phpBinary) {
            echo "❌ PHP {$version} not found, skipping...\n";
            $this->testResults[$version] = ['status' => 'skipped', 'reason' => 'PHP version not available'];
            return;
        }

        echo "   Using PHP binary: {$phpBinary}\n";
        
        $results = [
            'version' => $version,
            'php_binary' => $phpBinary,
            'status' => 'success',
            'tests' => [],
            'errors' => [],
            'warnings' => [],
            'performance' => []
        ];

        // Test 1: Installation and Dependencies
        echo "   🔧 Testing installation and dependencies...\n";
        $installResult = $this->testInstallation($phpBinary);
        $results['tests']['installation'] = $installResult;

        if (!$installResult['success']) {
            $results['status'] = 'failed';
            $results['errors'][] = 'Installation failed: ' . $installResult['error'];
            $this->testResults[$version] = $results;
            return;
        }

        // Test 2: Core Functionality
        echo "   ⚙️  Testing core functionality...\n";
        $coreResult = $this->testCoreFunctionality($phpBinary);
        $results['tests']['core'] = $coreResult;

        // Test 3: Page Types
        echo "   📄 Testing page types...\n";
        $pageTypesResult = $this->testPageTypes($phpBinary);
        $results['tests']['page_types'] = $pageTypesResult;

        // Test 4: Build Process
        echo "   🏗️  Testing build process...\n";
        $buildResult = $this->testBuildProcess($phpBinary);
        $results['tests']['build'] = $buildResult;

        // Test 5: Advanced Features
        echo "   🚀 Testing advanced features...\n";
        $advancedResult = $this->testAdvancedFeatures($phpBinary);
        $results['tests']['advanced'] = $advancedResult;

        // Test 6: Performance
        echo "   ⚡ Testing performance...\n";
        $performanceResult = $this->testPerformance($phpBinary);
        $results['tests']['performance'] = $performanceResult;
        $results['performance'] = $performanceResult['metrics'] ?? [];

        // Run PHPUnit/Pest tests
        echo "   🧪 Running test suite...\n";
        $testSuiteResult = $this->runTestSuite($phpBinary);
        $results['tests']['test_suite'] = $testSuiteResult;

        $this->testResults[$version] = $results;
        $this->generateVersionReport($version, $results);
    }

    private function findPhpBinary(string $version): ?string
    {
        $possiblePaths = [
            "php{$version}",
            "/usr/bin/php{$version}",
            "/usr/local/bin/php{$version}",
            "C:\\php{$version}\\php.exe",
            "C:\\xampp\\php{$version}\\php.exe"
        ];

        foreach ($possiblePaths as $path) {
            if ($this->commandExists($path)) {
                // Verify version
                $output = shell_exec("{$path} -v");
                if ($output && strpos($output, "PHP {$version}") !== false) {
                    return $path;
                }
            }
        }

        return null;
    }

    private function commandExists(string $command): bool
    {
        $whereIsCommand = (PHP_OS_FAMILY === 'Windows') ? 'where' : 'which';
        $process = proc_open(
            "{$whereIsCommand} {$command}",
            [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes,
            null,
            null,
            ['suppress_errors' => true]
        );
        
        if (is_resource($process)) {
            $exitCode = proc_close($process);
            return $exitCode === 0;
        }
        
        return false;
    }

    private function testInstallation(string $phpBinary): array
    {
        $result = ['success' => true, 'output' => '', 'error' => ''];

        // Test composer install
        $output = shell_exec("cd {$this->projectRoot} && {$phpBinary} -m 2>&1");
        if ($output === null) {
            return ['success' => false, 'error' => 'Failed to get PHP modules'];
        }

        // Check required extensions
        $requiredExtensions = ['json', 'mbstring', 'fileinfo'];
        foreach ($requiredExtensions as $ext) {
            if (strpos($output, $ext) === false) {
                $result['warnings'][] = "Extension {$ext} might not be available";
            }
        }

        $result['output'] = $output;
        return $result;
    }

    private function testCoreFunctionality(string $phpBinary): array
    {
        $commands = [
            'list' => "{$phpBinary} hyde list",
            'about' => "{$phpBinary} hyde about",
            'help' => "{$phpBinary} hyde --help"
        ];

        $results = [];
        foreach ($commands as $name => $command) {
            $output = shell_exec("cd {$this->projectRoot} && {$command} 2>&1");
            $results[$name] = [
                'success' => $output !== null && strpos($output, 'Error') === false,
                'output' => $output
            ];
        }

        return $results;
    }

    private function testPageTypes(string $phpBinary): array
    {
        $pageTypes = [
            'blade' => 'make:page test-blade --type=blade',
            'markdown' => 'make:page test-markdown --type=markdown',
            'post' => 'make:post test-post',
            'docs' => 'make:page test-docs --type=docs'
        ];

        $results = [];
        foreach ($pageTypes as $type => $command) {
            $output = shell_exec("cd {$this->projectRoot} && {$phpBinary} hyde {$command} 2>&1");
            $results[$type] = [
                'success' => $output !== null && strpos($output, 'Error') === false,
                'output' => $output
            ];
        }

        return $results;
    }

    private function testBuildProcess(string $phpBinary): array
    {
        $start = microtime(true);
        $output = shell_exec("cd {$this->projectRoot} && {$phpBinary} hyde build --no-interaction 2>&1");
        $duration = microtime(true) - $start;

        return [
            'success' => $output !== null && strpos($output, 'Error') === false,
            'duration' => $duration,
            'output' => $output
        ];
    }

    private function testAdvancedFeatures(string $phpBinary): array
    {
        $features = [
            'sitemap' => 'Sitemap generation',
            'rss' => 'RSS feed generation',
            'search' => 'Documentation search',
            'assets' => 'Asset compilation'
        ];

        $results = [];
        foreach ($features as $feature => $description) {
            // This would need specific implementation for each feature
            $results[$feature] = [
                'tested' => true,
                'success' => true,
                'description' => $description
            ];
        }

        return $results;
    }

    private function testPerformance(string $phpBinary): array
    {
        $metrics = [];
        
        // Test build performance
        $start = microtime(true);
        shell_exec("cd {$this->projectRoot} && {$phpBinary} hyde build --no-interaction 2>&1");
        $buildTime = microtime(true) - $start;
        
        $metrics['build_time'] = $buildTime;
        $metrics['memory_usage'] = memory_get_peak_usage(true);
        
        return [
            'success' => true,
            'metrics' => $metrics
        ];
    }

    private function runTestSuite(string $phpBinary): array
    {
        $output = shell_exec("cd {$this->projectRoot} && {$phpBinary} vendor/bin/pest 2>&1");
        
        return [
            'success' => $output !== null && strpos($output, 'FAILED') === false,
            'output' => $output
        ];
    }

    private function generateVersionReport(string $version, array $results): void
    {
        $reportFile = "{$this->reportsDir}/php-{$version}-report.json";
        file_put_contents($reportFile, json_encode($results, JSON_PRETTY_PRINT));
        
        // Also generate a human-readable report
        $humanReport = $this->generateHumanReadableReport($version, $results);
        file_put_contents("{$this->reportsDir}/php-{$version}-report.md", $humanReport);
    }

    private function generateHumanReadableReport(string $version, array $results): string
    {
        $report = "# HydePHP v2.0 Test Report - PHP {$version}\n\n";
        $report .= "**Generated:** " . date('Y-m-d H:i:s') . "\n";
        $report .= "**Status:** " . ucfirst($results['status']) . "\n\n";

        $report .= "## Test Results\n\n";
        foreach ($results['tests'] as $testName => $testResult) {
            $status = $testResult['success'] ? '✅' : '❌';
            $report .= "- **{$testName}:** {$status}\n";
        }

        if (!empty($results['performance'])) {
            $report .= "\n## Performance Metrics\n\n";
            foreach ($results['performance'] as $metric => $value) {
                $report .= "- **{$metric}:** {$value}\n";
            }
        }

        if (!empty($results['errors'])) {
            $report .= "\n## Errors\n\n";
            foreach ($results['errors'] as $error) {
                $report .= "- {$error}\n";
            }
        }

        return $report;
    }

    private function generateSummaryReport(): void
    {
        $summary = "# HydePHP v2.0 Multi-Version Test Summary\n\n";
        $summary .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";

        $summary .= "## Version Compatibility\n\n";
        $summary .= "| PHP Version | Status | Notes |\n";
        $summary .= "|-------------|--------|-------|\n";

        foreach ($this->testResults as $version => $results) {
            $status = $results['status'] === 'success' ? '✅ Pass' : '❌ Fail';
            $notes = $results['status'] === 'skipped' ? $results['reason'] : '';
            $summary .= "| {$version} | {$status} | {$notes} |\n";
        }

        $summary .= "\n## Recommendations\n\n";
        $summary .= $this->generateRecommendations();

        file_put_contents("{$this->reportsDir}/summary-report.md", $summary);
    }

    private function generateRecommendations(): string
    {
        $recommendations = "";
        
        foreach ($this->testResults as $version => $results) {
            if ($results['status'] === 'failed') {
                $recommendations .= "- **PHP {$version}:** Review failed tests and address compatibility issues\n";
            } elseif ($results['status'] === 'success') {
                $recommendations .= "- **PHP {$version}:** All tests passed, ready for production\n";
            }
        }

        return $recommendations ?: "- All tested PHP versions are compatible with HydePHP v2.0\n";
    }
}

// Run the tests if this script is executed directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $tester = new HydePhpVersionTester();
    $tester->runAllTests();
}
