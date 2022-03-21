<?php

namespace App\Core\Actions;

class ConvertsArrayToFrontMatter
{
    /**
     * Convert an array into YAML Front Matter.
     *
     * @todo add support for nested arrays
     *
     * @param array $array
     * @return string $yaml front matter
     */
    public function execute(array $array): string
    {
        $yaml = [];
        $yaml[] = "---";
        foreach ($array as $key => $value) {
            $yaml[] = "$key: $value";
        }

        $yaml[] = '---';
        $yaml[] = '';
        return implode("\n", $yaml);
    }
}
