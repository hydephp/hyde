#!/bin/bash

# HydePHP v2.0 Local Testing Script
# This script runs comprehensive tests for local development

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Function to get PHP version
get_php_version() {
    php -r "echo PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION;"
}

# Main testing function
run_tests() {
    local test_type="$1"
    
    print_status "Starting HydePHP v2.0 Testing Suite"
    echo "======================================"
    
    # Check PHP version
    local php_version=$(get_php_version)
    print_status "Detected PHP version: $php_version"
    
    if [[ ! "$php_version" =~ ^(8\.2|8\.3|8\.4) ]]; then
        print_warning "PHP version $php_version may not be officially supported"
        print_warning "Supported versions: 8.2, 8.3, 8.4"
    fi
    
    # Check required commands
    print_status "Checking prerequisites..."
    
    if ! command_exists php; then
        print_error "PHP is not installed or not in PATH"
        exit 1
    fi
    
    if ! command_exists composer; then
        print_error "Composer is not installed or not in PATH"
        exit 1
    fi
    
    # Check if vendor directory exists
    if [ ! -d "vendor" ]; then
        print_status "Installing dependencies..."
        composer install --no-interaction
    fi
    
    # Install testing dependencies if needed
    if [ ! -f "vendor/bin/pest" ]; then
        print_status "Installing testing dependencies..."
        composer require hyde/testing --dev --no-interaction
    fi
    
    # Run tests based on type
    case "$test_type" in
        "quick")
            run_quick_tests
            ;;
        "full")
            run_full_tests
            ;;
        "performance")
            run_performance_tests
            ;;
        "compatibility")
            run_compatibility_tests
            ;;
        *)
            print_status "Running default test suite..."
            run_default_tests
            ;;
    esac
    
    print_success "Testing completed!"
}

# Quick tests for development
run_quick_tests() {
    print_status "Running quick tests..."
    
    # Test CLI availability
    print_status "Testing CLI commands..."
    php hyde list > /dev/null
    php hyde about > /dev/null
    
    # Run basic test suite
    print_status "Running basic test suite..."
    vendor/bin/pest tests/ExampleTest.php tests/DefaultContentTest.php
    
    print_success "Quick tests completed"
}

# Full comprehensive tests
run_full_tests() {
    print_status "Running full test suite..."
    
    # Run all tests
    print_status "Running comprehensive feature tests..."
    vendor/bin/pest tests/ComprehensiveFeatureTest.php --verbose
    
    # Run PHP version specific tests
    local php_version=$(get_php_version)
    case "$php_version" in
        "8.2")
            print_status "Running PHP 8.2 compatibility tests..."
            vendor/bin/pest tests/PHP82CompatibilityTest.php --verbose
            ;;
        "8.3")
            print_status "Running PHP 8.3 compatibility tests..."
            vendor/bin/pest tests/PHP83CompatibilityTest.php --verbose
            ;;
        "8.4")
            print_status "Running PHP 8.4 compatibility tests..."
            vendor/bin/pest tests/PHP84CompatibilityTest.php --verbose
            ;;
    esac
    
    # Run existing tests
    print_status "Running existing test suite..."
    vendor/bin/pest tests/ExampleTest.php tests/DefaultContentTest.php tests/HydeCLITest.php tests/StaticSiteBuilderTest.php
    
    print_success "Full tests completed"
}

# Performance tests
run_performance_tests() {
    print_status "Running performance tests..."
    
    vendor/bin/pest tests/PerformanceTest.php --verbose
    
    print_success "Performance tests completed"
}

# Compatibility tests
run_compatibility_tests() {
    print_status "Running compatibility tests..."
    
    local php_version=$(get_php_version)
    
    # Test basic functionality
    print_status "Testing basic CLI functionality..."
    php hyde list
    php hyde about
    
    # Test page creation
    print_status "Testing page creation..."
    php hyde make:page "Test Page" --type=blade
    php hyde make:post "Test Post"
    
    # Test build process
    print_status "Testing build process..."
    php hyde build --no-interaction
    
    # Check for deprecation warnings
    print_status "Checking for deprecation warnings..."
    php -d error_reporting=E_ALL hyde list 2>&1 | grep -i "deprecated" && print_warning "Deprecation warnings found" || print_success "No deprecation warnings"
    
    # Cleanup test files
    rm -f _pages/test-page.blade.php
    rm -f _posts/test-post.md
    rm -rf _site
    
    print_success "Compatibility tests completed"
}

# Default tests
run_default_tests() {
    print_status "Running default test suite..."
    
    # Run existing tests
    vendor/bin/pest
    
    print_success "Default tests completed"
}

# Help function
show_help() {
    echo "HydePHP v2.0 Testing Script"
    echo ""
    echo "Usage: $0 [test_type]"
    echo ""
    echo "Test types:"
    echo "  quick         - Run quick tests for development"
    echo "  full          - Run comprehensive test suite"
    echo "  performance   - Run performance tests only"
    echo "  compatibility - Run compatibility tests"
    echo "  help          - Show this help message"
    echo ""
    echo "If no test type is specified, runs the default test suite."
}

# Main script logic
case "${1:-default}" in
    "help"|"-h"|"--help")
        show_help
        ;;
    *)
        run_tests "$1"
        ;;
esac
