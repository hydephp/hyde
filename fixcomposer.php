<?php

$json = json_decode(file_get_contents('composer.json'), true);
unset($json['repositories']);
file_put_contents('composer.json', json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));