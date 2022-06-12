<?php

namespace Hyde\Rocket\Http\Controllers;

use Hyde\Rocket\Models\Hyde;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/**
 * Routes a request to the realtime compiler.
 *
 * @todo Ping the realtime compiler to see if it's running.
 * @todo Allow host to be specified?
 */
class RealtimeCompiler
{
    public function render(Request $request)
    {
        $path = $request->get('path', '');

        return redirect('http://localhost:8080/' . $path);
    }

    public function markdown(Request $request)
    {
        $path = Hyde::path($request->get('path', ''));

        if (! file_exists($path)) {
            return response('File not found.', 404);
        }

        return view('markdown-preview', [
            'page' => basename($path),
            'markdown' => Str::markdown(YamlFrontMatter::markdownCompatibleParse(file_get_contents($path))->body())
        ]);
    }
}
