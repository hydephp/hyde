<?php

namespace Tests\Unit;

use Hyde\Framework\Models\MarkdownDocument;
use Tests\TestCase;

/**
 * Class HasDynamicTitleTest.
 *
 * @covers \Hyde\Framework\Concerns\HasDynamicTitle
 */
class HasDynamicTitleTest extends TestCase
{
    protected array $matter;

    // Test it can find title from front matter.
    public function testFindTitleFromFrontMatter()
    {
        $document = new MarkdownDocument([
            'title' => 'My Title',
        ], body: '');

        $this->assertEquals('My Title', $document->findTitleForDocument());
    }

    // Test it can find title from H1 tag.
    public function testFindTitleFromH1Tag()
    {
        $document = new MarkdownDocument([], body: '# My Title');

        $this->assertEquals('My Title', $document->findTitleForDocument());
    }

    // Test it can find title from slug.
    public function testFindTitleFromSlug()
    {
        $document = new MarkdownDocument([], body: '', slug: 'my-title');
        $this->assertEquals('My Title', $document->findTitleForDocument());
    }
}
