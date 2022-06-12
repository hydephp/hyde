<?php

namespace Hyde\Rocket\Http\Controllers;

use Hyde\Rocket\Models\Project;
use Illuminate\Http\Request;

/**
 * The Filesystem API gives access to the underlying filesystem.
 * It currently only supports Windows, but PRs are welcome.
 *
 * Warning: This is one of many reasons why this project must
 * only ever be used on local development installations!
 */
class FilesystemController extends Controller
{
    public function __construct()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            throw new \Exception('This API is only supported on Windows. ' .
                'Please send a PR to open up support for other systems!');
        }
    }

    public function open(Request $request)
    {
        if (! $request->has('path')) {
            return response()->json([
                'error' => 'Missing path parameter.'
            ], 400);
        }

        $file = trim(Project::get()->path . '/' . $request->input('path'), '/');

        if (! file_exists($file)) {
            return response()->json([
                'error' => 'File does not exist.'
            ], 404);
        }

        if (is_dir($file)) {
            shell_exec('explorer.exe "' . $file . '"');
        } else {
            shell_exec('start "" "' . $file . '"');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true
            ]);
        }

        return redirect($request->get('back', '/'));
    }
}
