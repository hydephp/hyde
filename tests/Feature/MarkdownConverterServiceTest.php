<?php

namespace Tests\Feature;

use Hyde\Framework\Services\MarkdownConverterService;
use Tests\TestCase;

/**
 * @todo Run without the heading permalink extension ones the extensions are customizable.
 */
class MarkdownConverterServiceTest extends TestCase
{
    public function test_service_can_parse_markdown_to_html()
    {
        $markdown = '# Hello World!';

        $html = (new MarkdownConverterService($markdown))->parse();

        $this->assertIsString($html);
        $this->assertEquals("<h1><a id=\"hello-world\" href=\"#hello-world\" class=\"heading-permalink\" aria-hidden=\"true\" title=\"Permalink\"></a>Hello World!</h1>\n", $html);
    }

    public function test_torchlight_integration_injects_attribution()
    {
        $markdown = '# Hello World! <!-- Syntax highlighted by torchlight.dev -->';

        $service = new MarkdownConverterService($markdown, true, true);

        $html = $service->parse();

        $this->assertStringContainsString('Syntax highlighting by <a href="https://torchlight.dev/" '
                .'rel="noopener nofollow">Torchlight.dev</a>', $html);
    }
}
