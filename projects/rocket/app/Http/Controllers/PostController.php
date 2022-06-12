<?php

namespace Hyde\Rocket\Http\Controllers;

use Hyde\Framework\Actions\CreatesNewMarkdownPostFile;
use Hyde\Framework\Exceptions\FileConflictException;
use Hyde\Framework\Models\Parsers\MarkdownPostParser;
use Hyde\Rocket\Models\Hyde;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(string $slug, Request $request)
    {
        $path = Hyde::path($localPath = '_posts/' . $slug . '.md');

        if (! file_exists($path)) {
            return response('File not found.', 404);
        }

        return view('post-manager', [
            'post' => (new MarkdownPostParser($slug))->get(),
            'slug' => $slug,
            'path' => $path,
            'localPath' => $localPath,
            'markdown' => file_get_contents($path),
            'saved' => $request->has('saved'),
        ]);
    }

    public function create()
    {
        return view('create-post');
    }

    public function store(Request $request)
    {
        $creator = new CreatesNewMarkdownPostFile(
            $request->input('title'),
            $request->input('description'),
            $request->input('category'),
            $request->input('author')
        );   

        try {
            $creator->save();
        } catch (FileConflictException $e) {
            return response([
                'error' => 'A post with the same title already exists.',
            ]);
        }

        return redirect('/_posts/' . $creator->slug . '?saved=true');
    }

    public function update(string $slug, Request $request)
    {
        $path = Hyde::path('_posts/' . $slug . '.md');

        if (! file_exists($path)) {
            return response('File not found.', 404);
        }

        file_put_contents($path, $request->get('markdown'));

        return redirect('/_posts/' . $slug . '?saved=true');
    }
}
