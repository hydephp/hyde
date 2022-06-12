<?php

namespace Hyde\Rocket\Http\Controllers;

use GuzzleHttp\Client;

/**
 * Controller for general API requests that don't currently require their own controller.
 */
class ApiController extends Controller
{
    public function pingRealtimeCompiler()
    {
        return static::isRealtimeCompilerRunning()
            ? response()->json(['success' => true])
            : response()->json([
                'success' => false,
                'error' => 'Could not ping Realtime Compiler on default port 8080'
            ]);
    }

    public static function isRealtimeCompilerRunning()
    {
        try {
            $client = new Client(['timeout' => 1]);
            $client->head('http://localhost:8080');
            return true;
        }
        catch (\Throwable) {
            return false;
        }
    }
}
