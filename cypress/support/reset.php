<?php

// Reset the file system to a known state

$pages_dir = realpath(__DIR__ . '/../../_pages');
echo 'Emptying ' . $pages_dir, PHP_EOL;
array_map('unlink', glob("$pages_dir/*"));

$site_dir = realpath(__DIR__ . '/../../_site');
echo 'Emptying ' . $site_dir, PHP_EOL;
array_map('unlink', glob("$site_dir/*.*"));