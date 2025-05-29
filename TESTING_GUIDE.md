# HydePHP v2.0 Beta Testing Guide

This comprehensive guide provides systematic testing procedures for HydePHP v2.0 across PHP 8.2, 8.3, and 8.4.

## 🎯 Testing Objectives

- Verify compatibility across PHP 8.2, 8.3, and 8.4
- Identify deprecation warnings and fatal errors
- Test all core features and integrations
- Measure performance characteristics
- Validate production readiness

## 🔧 Prerequisites

### Required PHP Versions
- PHP 8.2.x (minimum supported)
- PHP 8.3.x (current stable)
- PHP 8.4.x (latest release)

### Required Extensions
- `json`
- `mbstring`
- `fileinfo`
- `zip`

### Testing Tools
- Composer
- Pest/PHPUnit
- Git

## 📋 Testing Matrix

### Phase 1: Installation Testing

#### For Each PHP Version (8.2, 8.3, 8.4):

**1. Fresh Installation**
```bash
# Create new project
composer create-project hyde/hyde test-hyde-php82 --prefer-dist

# Verify installation
cd test-hyde-php82
php hyde list
```

**Expected Results:**
- ✅ No dependency conflicts
- ✅ No deprecation warnings during installation
- ✅ Hyde CLI accessible and functional

**2. Dependency Verification**
```bash
# Check for any dependency issues
composer diagnose
composer validate

# Verify autoloading
php -r "require 'vendor/autoload.php'; echo 'Autoload OK';"
```

### Phase 2: Core Functionality Testing

**1. CLI Commands**
```bash
# Test all major commands
php hyde list
php hyde about
php hyde build --help
php hyde make:page --help
php hyde make:post --help
```

**2. Page Creation**
```bash
# Test all page types
php hyde make:page "Test Blade Page" --type=blade
php hyde make:page "Test Markdown Page" --type=markdown
php hyde make:post "Test Blog Post"
php hyde make:page "Test Documentation" --type=docs
```

**3. Build Process**
```bash
# Test site building
php hyde build --no-interaction

# Verify output
ls -la _site/
```

### Phase 3: Feature Testing

**1. Blade Pages**
- Create Blade page with complex layouts
- Test Blade directives and components
- Verify compilation to HTML

**2. Markdown Processing**
- Test various Markdown syntax
- Verify front matter processing
- Check code block rendering

**3. Blog Posts**
- Create posts with different dates
- Test post listing generation
- Verify RSS feed generation

**4. Documentation**
- Create documentation with navigation
- Test search functionality
- Verify table of contents generation

**5. Advanced Features**
- Torchlight integration (if configured)
- Data collections
- Asset compilation
- Sitemap generation

### Phase 4: Performance Testing

**1. Build Performance**
```bash
# Time the build process
time php hyde build --no-interaction
```

**2. Memory Usage**
```bash
# Monitor memory usage during build
php -d memory_limit=128M hyde build --no-interaction
```

**3. Large Site Testing**
- Create 50+ pages
- Measure build time
- Check memory consumption

### Phase 5: Integration Testing

**1. Realtime Compiler**
```bash
# Test development server (if available)
php hyde serve
```

**2. Asset Pipeline**
```bash
# Test Vite integration
npm install
npm run build
```

**3. External Integrations**
- Test Torchlight (if token available)
- Verify GitHub integration features

## 🚀 Automated Testing

### Running the Test Suite

**1. Install Testing Dependencies**
```bash
composer require hyde/testing --dev
```

**2. Run Comprehensive Tests**
```bash
# Run all tests
vendor/bin/pest

# Run specific test suites
vendor/bin/pest tests/PHP82CompatibilityTest.php
vendor/bin/pest tests/PHP83CompatibilityTest.php
vendor/bin/pest tests/PHP84CompatibilityTest.php
vendor/bin/pest tests/ComprehensiveFeatureTest.php
vendor/bin/pest tests/PerformanceTest.php
```

**3. Automated Multi-Version Testing**
```bash
# Run the automated testing script
php scripts/test-php-versions.php
```

## 📊 What to Watch For

### Critical Issues
- ❌ Fatal errors on any PHP version
- ❌ Composer dependency conflicts
- ❌ Build process failures
- ❌ Missing or corrupted output files

### Warning Signs
- ⚠️ Deprecation warnings
- ⚠️ Performance degradation (>50% slower)
- ⚠️ Memory usage spikes
- ⚠️ Inconsistent behavior between versions

### Performance Benchmarks
- **Single page build:** < 5 seconds
- **10 pages build:** < 15 seconds
- **100 pages build:** < 60 seconds
- **Memory usage:** < 128MB for typical sites

## 📝 Reporting Issues

### Required Information
1. **PHP Version:** Exact version (e.g., 8.3.2)
2. **Operating System:** OS and version
3. **Error Details:** Full error messages and stack traces
4. **Steps to Reproduce:** Exact commands and inputs
5. **Expected vs Actual:** What should happen vs what happened

### Issue Template
```markdown
## Bug Report

**PHP Version:** 8.x.x
**OS:** Windows/macOS/Linux
**HydePHP Version:** 2.0.x

### Description
Brief description of the issue

### Steps to Reproduce
1. Step one
2. Step two
3. Step three

### Expected Behavior
What should happen

### Actual Behavior
What actually happened

### Error Output
```
Paste error messages here
```

### Additional Context
Any other relevant information
```

## ✅ Testing Checklist

### Installation Phase
- [ ] PHP 8.2 installation successful
- [ ] PHP 8.3 installation successful  
- [ ] PHP 8.4 installation successful
- [ ] No dependency conflicts on any version
- [ ] All required extensions available

### Core Functionality
- [ ] CLI commands work on all versions
- [ ] Page creation commands functional
- [ ] Build process completes successfully
- [ ] No deprecation warnings during normal operation

### Feature Testing
- [ ] Blade pages compile correctly
- [ ] Markdown processing works
- [ ] Blog posts generate properly
- [ ] Documentation features functional
- [ ] RSS/Sitemap generation works
- [ ] Asset compilation successful

### Performance Testing
- [ ] Build times within acceptable ranges
- [ ] Memory usage reasonable
- [ ] No significant performance regressions

### Integration Testing
- [ ] Realtime compiler works (if available)
- [ ] Vite integration functional
- [ ] External services integrate properly

### Cross-Version Compatibility
- [ ] Consistent behavior across PHP versions
- [ ] No version-specific bugs
- [ ] Performance similar across versions

## 🎉 Success Criteria

HydePHP v2.0 is ready for release when:

1. ✅ All tests pass on PHP 8.2, 8.3, and 8.4
2. ✅ No critical bugs or fatal errors
3. ✅ Performance meets or exceeds v1.x benchmarks
4. ✅ All documented features work as expected
5. ✅ No unresolved deprecation warnings
6. ✅ Documentation is complete and accurate

## 📞 Support

For testing support and questions:
- GitHub Issues: https://github.com/hydephp/hyde/issues
- Documentation: https://hydephp.com/docs
- Community: https://hydephp.com/community
