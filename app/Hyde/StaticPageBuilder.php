<?php

namespace App\Hyde;

use App\Hyde\Models\MarkdownPost;
use App\Hyde\Models\MarkdownPage;
use App\Hyde\Models\BladePage;

/**
 * Generates a static HTML page and saves it.
 * Currently, only supports the Post model but will
 * support the upcoming Page model when that is implemented.
 */
class StaticPageBuilder
{
    /**
     * @param MarkdownPost|MarkdownPage|BladePage $page the Page to compile into HTML
     * @param bool $runAutomatically if set to true the class will invoke when constructed
     */
    public function __construct(protected MarkdownPost|MarkdownPage|BladePage $page, bool $runAutomatically = false)
    {
        if ($runAutomatically) {
            $this->__invoke();
        }
    }

    public function __invoke()
    {
        if ($this->page instanceof MarkdownPost) {
            $this->save('posts/' . $this->page->slug, $this->compilePost());
        }

        if ($this->page instanceof MarkdownPage) {
            $this->save($this->page->slug, $this->compilePage());
        }

        if ($this->page instanceof BladePage) {
            $this->save($this->page->view, $this->compileView());
        }
    }

    /**
     * @param string $location of the output file relative to _site/
     * @param string $contents to save to the file
     */
    private function save(string $location, string $contents)
    {
        $path = base_path('./_site') . '/' . $location . '.html';
        file_put_contents($path, $contents);
    }

    /**
     * Compile a Post into HTML using the Blade View
     * @return string
     */
    private function compilePost(): string
    {
        return view('post')->with([
            'post' => $this->page
        ])->render();
    }
    
    /**
    * Compile a Page into HTML using the Blade View
    * @return string
    */
    private function compilePage(): string
    {
        return view('page')->with([
           'title' => $this->page->title,
           'pageContent' => $this->page->content
        ])->render();
    }
   

    /**
     * Compile a custom Blade View into HTML
     * @return string
     */
    private function compileView(): string
    {
        return view('pages/' . $this->page->view)->render();
    }
}
