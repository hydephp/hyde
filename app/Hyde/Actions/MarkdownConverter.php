<?php

namespace App\Hyde\Actions;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use Torchlight\Commonmark\V2\TorchlightExtension;

/**
 * Converts Markdown into HTML
 */
class MarkdownConverter
{
    /**
     * Parse the Markdown into HTML.
     *
     * @param string $markdown
     * @return string $html
     */
    public static function parse(string $markdown): string
    {
        $converter = new CommonMarkConverter();

        $converter->getEnvironment()->addExtension(new GithubFlavoredMarkdownExtension());
        if (config('torchlight.token') !== null) {
            $converter->getEnvironment()->addExtension(new TorchlightExtension());
        }

        return $converter->convert($markdown);
    }
}
