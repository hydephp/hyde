<?php

namespace App\Hyde;

use App\Hyde\Actions\MarkdownConverter;
use App\Hyde\Models\DocumentationPage;
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

    public null|int|false $createdFileSize;
    public null|string $createdFilePath;

    /**
     * @param MarkdownPost|MarkdownPage|BladePage|DocumentationPage $page the Page to compile into HTML
     * @param bool $runAutomatically if set to true the class will invoke when constructed
     */
    public function __construct(protected MarkdownPost|MarkdownPage|BladePage|DocumentationPage $page, bool $runAutomatically = false)
    {
        if ($runAutomatically) {
            $this->createdFileSize = $this->__invoke();
        }
    }

    public function __invoke()
    {
        if ($this->page instanceof MarkdownPost) {
            return $this->save('posts/' . $this->page->slug, $this->compilePost());
        }

        if ($this->page instanceof MarkdownPage) {
            return $this->save($this->page->slug, $this->compilePage());
        }

        if ($this->page instanceof BladePage) {
            return $this->save($this->page->view, $this->compileView());
        }

        if ($this->page instanceof DocumentationPage) {
            return $this->save('docs/' . $this->page->slug, $this->compileDocs());
        }
    }

    /**
     * Get the debug data
     * @return array
     */
    public function getDebugOutput(bool $relativeFilePath = true): array
    {
        return [
            'createdFileSize' => $this->createdFileSize,
            'createdFilePath' => $relativeFilePath
                ? str_replace(base_path(), '', $this->createdFilePath)
                : $this->createdFilePath ,
        ];
    }

    /**
     * @param string $location of the output file relative to _site/
     * @param string $contents to save to the file
     */
    private function save(string $location, string $contents)
    {
        $path = base_path('./_site') . '/' . $location . '.html';
        $this->createdFilePath = $path;
        return file_put_contents($path, $contents);
    }

    /**
     * Compile a Post into HTML using the Blade View
     * @return string
     */
    private function compilePost(): string
    {
        return view('post')->with([
            'post' => $this->page,
            'title' => $this->page->matter['title'],
            'markdown' => MarkdownConverter::parse($this->page->body),
            'currentPage' => 'posts/' . $this->page->slug
        ])->render();
    }

    /**
     * Compile a Documentation page into HTML using the Blade View
     * @return string
     */
    private function compileDocs(): string
    {
        return view('docs')->with([
            'docs' => $this->page,
            'title' => $this->page->title,
            'markdown' => MarkdownConverter::parse($this->page->content),
            'currentPage' => 'docs/' . $this->page->slug
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
            'pageContent' => $this->page->content,
            'currentPage' => $this->page->slug
        ])->render();
    }


    /**
     * Compile a custom Blade View into HTML
     * @return string
     */
    private function compileView(): string
    {
        return view('pages/' . $this->page->view, [
            'currentPage' => $this->page->view
        ])->render();
    }
}
