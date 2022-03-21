<?php

namespace App\Core;

use JetBrains\PhpStorm\ArrayShape;
use App\Core\Actions\MarkdownConverter;
use App\Core\Models\DocumentationPage;
use App\Core\Models\MarkdownPost;
use App\Core\Models\MarkdownPage;
use App\Core\Models\BladePage;

/**
 * Generates a static HTML page and saves it.
 */
class StaticPageBuilder
{
    /**
     * Debug output: The size of the created file
     * @var int|bool|void|null
     */
    public null|int|false $createdFileSize;
    /**
     * Debug output: The path of the created file
     * @var string|null
     */
    public null|string $createdFilePath;

    /**
     * Construct the class.
     * @param MarkdownPost|MarkdownPage|BladePage|DocumentationPage $page the Page to compile into HTML
     * @param bool $runAutomatically if set to true the class will invoke when constructed
     */
    public function __construct(
        protected MarkdownPost|MarkdownPage|BladePage|DocumentationPage $page,
        bool $runAutomatically = false
    ) {
        if ($runAutomatically) {
            $this->createdFileSize = $this->__invoke();
        }
    }

    /**
     * Run the page builder.
     * @return bool|int|void
     */
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
     * Get the debug data.
     * @param bool $relativeFilePath should the returned filepath be relative instead of absolute?
     * @return array
     */
    #[ArrayShape(['createdFileSize' => "mixed", 'createdFilePath' => "mixed"])]
    public function getDebugOutput(bool $relativeFilePath = true): array
    {
        return [
            'createdFileSize' => $this->createdFileSize,
            'createdFilePath' => $relativeFilePath
                ? str_replace(Hyde::path(), '', $this->createdFilePath)
                : $this->createdFilePath ,
        ];
    }

    /**
     * Save the compiled HTML to file.
     * @param string $location of the output file relative to _site/
     * @param string $contents to save to the file
     */
    private function save(string $location, string $contents): bool|int
    {
        $path = Hyde::path("_site/$location.html");
        $this->createdFilePath = $path;
        return file_put_contents($path, $contents);
    }

    /**
     * Compile a Post into HTML using the Blade View.
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
     * Compile a Documentation page into HTML using the Blade View.
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
    * Compile a Markdown Page into HTML using the Blade View.
    * @return string
    */
    private function compilePage(): string
    {
        return view('page')->with([
            'title' => $this->page->title,
            'markdown' => MarkdownConverter::parse($this->page->content),
            'currentPage' => $this->page->slug
        ])->render();
    }


    /**
     * Compile a custom Blade View into HTML.
     * @return string
     */
    private function compileView(): string
    {
        return view('pages/' . $this->page->view, [
            'currentPage' => $this->page->view
        ])->render();
    }
}
