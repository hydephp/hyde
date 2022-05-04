<?php

// Reset the file system to a known state

$pages_dir = realpath(__DIR__ . '/../../_pages');
array_map('unlink', glob("$pages_dir/*"));

$docs_dir = realpath(__DIR__ . '/../../_docs');
array_map('unlink', glob("$docs_dir/*"));


$site_dir = realpath(__DIR__ . '/../../_site');
array_map('unlink', glob("$site_dir/*.*"));
array_map('unlink', glob("$site_dir/docs/*.*"));