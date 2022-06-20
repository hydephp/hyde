<?php

use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;

/**
 * @deprecated You should not run tests in a production environment.
 */
if (! function_exists('backup')) {
    function backup(string $filepath)
    {
        if (file_exists($filepath)) {
            copy($filepath, $filepath.'.bak');
        }
    }
}

if (! function_exists('restore')) {
    function restore(string $filepath)
    {
        if (file_exists($filepath.'.bak')) {
            copy($filepath.'.bak', $filepath);
            unlink($filepath.'.bak');
        }
    }
}

if (! function_exists('unlinkIfExists')) {
    function unlinkIfExists(string $filepath)
    {
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }
}

if (! function_exists('backupDirectory')) {
    function backupDirectory(string $directory)
    {
        if (file_exists($directory)) {
            File::copyDirectory($directory, $directory.'-bak', true);
        }
    }
}

if (! function_exists('restoreDirectory')) {
    function restoreDirectory(string $directory)
    {
        if (file_exists($directory.'-bak')) {
            File::moveDirectory($directory.'-bak', $directory, true);
            File::deleteDirectory($directory.'-bak');
        }
    }
}

if (! function_exists('deleteDirectory')) {
    function deleteDirectory(string $directory)
    {
        if (file_exists($directory)) {
            File::deleteDirectory($directory);
        }
    }
}

if (! function_exists('createTestPost')) {
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
}
