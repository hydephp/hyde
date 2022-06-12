<?php

namespace Hyde\Rocket\Http\Controllers;

use Hyde\Rocket\Models\Project;
use Hyde\Framework\Hyde;

class DebugController extends Controller
{
    public function __invoke()
    {
        ob_get_clean();

        echo '<pre>';

        echo '<h1>Hyde Rocket Debug Screen</h1>';

        echo '<h2>Project Information</h2>';
        $information = [
            'Hyde/Framework version' => Hyde::version(),
            'Hyde project path' => Hyde::path(),
            'PHP version' => phpversion() . ' (' . PHP_SAPI . ')',
            'Lumen version' => app()->version(),
        ];
        dump($information);

        echo '<h2>HydePHP Debug Information</h2>';
        echo '<blockquote>';
        echo '<i>Running <code>$ php '.Hyde::path().DIRECTORY_SEPARATOR.'hyde debug </code></i>', "\n\n";
        Project::get('artisan')->passthru('debug');
        echo '</blockquote>';
    }
}
