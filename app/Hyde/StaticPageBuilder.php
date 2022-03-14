<?php

namespace App\Hyde;

/**
 * Generates a static HTML page and saves it.
 * Currently, only supports the Post model but will
 * support the upcoming Page model when that is implemented.
 */
class StaticPageBuilder
{
    /**
     * @param MarkdownPost $post the Post to compile into HTML
     * @param bool $runAutomatically if set to true the class will invoke when constructed
     */
    public function __construct(protected MarkdownPost $post, bool $runAutomatically = false)
    {
        if ($runAutomatically) {
            $this->__invoke();
        }
    }

    public function __invoke()
    {
        if ($this->post instanceof MarkdownPost) {
            $this->save('posts/' . $this->post->slug, $this->compilePost());
        }
    }

    /**
     * @param string $location of the output file relative to _site/
     * @param string $contents to save to the file
     */
    public function save(string $location, string $contents)
    {
        $path = base_path('./_site') . '/' . $location . '.html';
        file_put_contents($path, $contents);
    }

    public function compilePost()
    {
        return view('post')->with([
            'post' => $this->post
        ])->render();
    }
}
