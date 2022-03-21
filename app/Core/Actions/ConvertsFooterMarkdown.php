<?php

namespace App\Core\Actions;

use Illuminate\Support\Str;
use function config;

class ConvertsFooterMarkdown
{
    /**
     * Convert the Markdown text if supplied in the config,
     * or fall back to default to generate HTML for the footer.
     *
     * @return string $html
     */
    public static function execute(): string
    {
        return Str::markdown(config(
            'hyde.footer.markdown',
            'Site built with the Free and Open Source [HydePHP](https://github.com/hydephp/hyde).
		License [MIT](https://github.com/hydephp/hyde/blob/master/LICENSE.md).'
        ));
    }
}
