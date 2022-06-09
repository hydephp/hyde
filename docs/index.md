# Elegant and Powerful Static App Builder

<p> 
    <!-- <a href="https://packagist.org/packages/hyde/hyde"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/v/hyde/hyde" alt="Latest Version on Packagist" title="Latest version of Hyde/Hyde"></a> -->
    <a href="https://packagist.org/packages/hyde/framework"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/v/hyde/framework?include_prereleases" alt="Latest Version on Packagist" title="Latest version of Hyde/Framework"></a> 
    <a href="https://packagist.org/packages/hyde/framework"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/dt/hyde/framework" alt="Total Downloads on Packagist"></a> 
    <a href="https://github.com/hydephp/hyde/blob/master/LICENSE.md"> <img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/github/license/hydephp/hyde" alt="License MIT"> </a>
    <a href="https://hydephp.com/developer-tools/coverage-report/"><img style="display: inline; margin: 4px 2px;" src="https://cdn.desilva.se/microservices/coverbadges/badges/9b8f6a9a7a48a2df54e6751790bad8bd910015301e379f334d6ec74c4c3806d1.svg" alt="Test Coverage" title="Average coverage between categories"></a>
    <img style="display: inline; margin: 4px 2px;" src="https://github.com/hydephp/framework/actions/workflows/test-suite.yml/badge.svg" alt="Test Suite">  <img style="display: inline; margin: 4px 2px;" src="https://github.styleci.io/repos/472503421/shield?branch=master" alt="StyleCI Status"> 
</p>

## ⚠ Beta Software Warning
Heads up! HydePHP is still new and currently in beta. Please report any bugs and issues in the appropriate issue tracker. Versions in the 0.x series might not be stable and may change at any time. No backwards compatibility guarantees are made and there will be breaking changes without notice.

Please wait until v1.0 for production use and remember to back up your source files before updating (use Git!). See https://hydephp.com/docs/master/updating-hyde.html for the upgrade guide.


## About HydePHP

HydePHP is a new Static Site Builder focused on writing content, not markup. With Hyde, it is easy to create static websites, blogs, and documentation pages using Markdown and (optionally) Blade.

Hyde is different from other static site builders. It's blazingly fast and stupidly simple to get started with, yet it has the full power of Laravel when you need it. 

Hyde makes creating websites easy and fun by taking care of the boring stuff, like routing, writing boilerplate, and endless configuration. Instead, when you create a new Hyde project, everything you need to get started is already there -- including precompiled TailwindCSS, well crafted Blade templates, and easy asset management.

Hyde is powered by Laravel Zero which is a stripped-down version of the robust Laravel Framework. Using Blade templates the site is intelligently compiled into static HTML.

Hyde was inspired by JekyllRB and is created for Developers who are comfortable writing posts in Markdown. It requires virtually no configuration out of the box as it favours convention over configuration and is preconfigured with sensible defaults.


## Installation

The recommended method of installation is using Composer.

```bash
composer create-project hyde/hyde --stability=dev
```

For the best experience you should have PHP >= 8.0, Composer, and NPM installed.

### To learn more, head over to the [quickstart page](quickstart.html).