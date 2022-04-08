<?php

namespace Tests\Unit;

use Hyde\Framework\Actions\MarkdownConverter;
use Tests\TestCase;

/**
 * Class MarkdownConverterTest.
 *
 * @covers \Hyde\Framework\Actions\MarkdownConverter
 */
class MarkdownConverterTest extends TestCase
{
    public function test_parse(): void
    {
        $markdown = '# Hello World!';

        $html = MarkdownConverter::parse($markdown);

        $this->assertIsString($html);
        $this->assertEquals("<h1>Hello World!</h1>\n", $html);
    }
}
