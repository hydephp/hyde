<?php

namespace Tests\Feature;

use Hyde\Framework\Hyde;
use Tests\TestCase;

class HydeDocsIndexPathTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->clearBoth();
    }

    protected function tearDown(): void
    {
        $this->clearBoth();

        parent::tearDown();
    }

    public function test_returns_false_if_no_index_or_readme_exists()
    {
        $this->assertEquals(false, Hyde::docsIndexPath());
    }

    public function test_returns_readme_if_only_readme_exists()
    {
        $this->setReadme();
        $this->assertEquals(Hyde::docsDirectory().'/readme.html', Hyde::docsIndexPath());
    }

    public function test_returns_index_if_both_readme_and_index_exists()
    {
        $this->setReadme();
        $this->setIndex();
        $this->assertEquals(Hyde::docsDirectory().'/index.html', Hyde::docsIndexPath());
    }

    public function test_returns_index_if_only_index_exist()
    {
        $this->setIndex();
        $this->assertEquals(Hyde::docsDirectory().'/index.html', Hyde::docsIndexPath());
    }

    private function setReadme()
    {
        file_put_contents(Hyde::path('_docs/readme.md'), '');
    }

    private function setIndex()
    {
        file_put_contents(Hyde::path('_docs/index.md'), '');
    }

    private function clearBoth()
    {
        @unlink(Hyde::path('_docs/index.md'));
        @unlink(Hyde::path('_docs/readme.md'));
    }
}
