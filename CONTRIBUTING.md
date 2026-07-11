# Contributing to HydePHP

Thank you for considering contributing to HydePHP! This document provides guidelines and instructions for contributing to the HydePHP project.

## Quick Links

- [Community Portal](https://hydephp.com/community)
- [Monorepo Development Repository](https://github.com/hydephp/develop)
- [Core Framework Repository](https://github.com/hydephp/framework)
- [Official Documentation](https://hydephp.com/docs)

## How HydePHP Is Structured

HydePHP consists of several core components, with development primarily done in a monorepo:

1. **Hyde/Hyde** (this repository) - The end-user project that you interact with when creating a website
2. **Hyde/Framework** - The core logic including models, generators, commands, and views
3. **HydeFront** - Frontend assets including stylesheets and scripts

Development happens in the [HydePHP/Develop](https://github.com/hydephp/develop) monorepo, where changes are automatically split into separate read-only repositories for each component.

## How to Contribute

### Before You Start

1. **Find an issue or create one** - Check if the change you want to make has been discussed
2. **Check existing PRs** - Make sure someone isn't already working on it

### Development Process

1. **Fork the monorepo** - All development happens at [hydephp/develop](https://github.com/hydephp/develop)
2. **Clone your fork** and run `composer install`
3. **Create a branch** for your changes
4. **Make your changes** in the appropriate package directory
5. **Add tests** - Your patch won't be accepted without tests
6. **Run the tests** - Make sure everything passes
7. **Submit a pull request** to the monorepo

### Coding Standards and Testing

- We follow the [PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
- All code should be properly tested
- We try to align with Laravel conventions where possible

## Which Branch?

- **Bug fixes for the current stable release** should be sent to `2.x`
- **Fixes for the supported v1 release line** should be sent to `1.x`
- **Minor features** that are fully backward compatible with v2 should be sent to `2.x`
- **Major features** or breaking changes for v3 should be sent to `master`

## Project Goals

When contributing, keep in mind the core goals of HydePHP:

1. **Developer experience first** - Creating sites with Hyde should be a joy
2. **Zero config setup** - Hyde follows convention over configuration with sensible defaults
3. **Customizable when needed** - Options for customization should always be available but not required

## Documentation

- Document any change in behavior in your PR
- Update README.md or other documentation files as needed

## Pull Request Guidelines

1. **One PR per feature/fix** - Keep changes focused on a single goal
2. **Coherent history** - Squash intermediate commits
3. **Add tests** - All PRs should include tests that prove the fix/feature works
4. **Document changes** - Update relevant documentation
5. **Consider release cycle** - We follow [SemVer v2.0.0](https://semver.org/)

## Getting Help

If you need help or have questions about contributing:

- Join the community discussions on GitHub
- Check the [Community Portal](https://hydephp.com/community) for more resources
- Read the detailed [Contributing Guide](https://github.com/hydephp/develop/blob/master/CONTRIBUTING.md) in the monorepo

## Code of Conduct

Please note that this project adheres to a Code of Conduct. By participating, you are expected to uphold this code. The full Code of Conduct can be found in the HydePHP community health files.

---

**Thank you for contributing to HydePHP!**