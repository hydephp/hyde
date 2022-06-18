<?php

use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;

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
