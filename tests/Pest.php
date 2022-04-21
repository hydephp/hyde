<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function backup(string $filepath)
{
    if (file_exists($filepath)) {
        copy($filepath, $filepath.'.bak');
    }
}

function restore(string $filepath)
{
    if (file_exists($filepath.'.bak')) {
        copy($filepath.'.bak', $filepath);
        unlink($filepath.'.bak');
    }
}

function unlinkIfExists(string $filepath)
{
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}

function backupDirectory(string $directory)
{
    if (file_exists($directory)) {
        File::copyDirectory($directory, $directory.'-bak', true);
    }
}

function restoreDirectory(string $directory)
{
    if (file_exists($directory.'-bak')) {
        File::moveDirectory($directory.'-bak', $directory, true);
        File::deleteDirectory($directory.'-bak');
    }
}

function deleteDirectory(string $directory)
{
    if (file_exists($directory)) {
        File::deleteDirectory($directory);
    }
}

function createTestPost(?string $path = null): string
{
    $path = Hyde::path($path ?? '_posts/test-post.md');
    file_put_contents($path, '---
title: My New Post
category: blog
author: Mr. Hyde
---

# My New Post

This is a post stub used in the automated tests
');

    return $path;
}

uses()->group('validators')->in('validators');
