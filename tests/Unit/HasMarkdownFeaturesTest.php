<?php

namespace Tests\Unit;

use Hyde\Framework\Actions\ServiceActions\HasMarkdownFeatures;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * @covers \Hyde\Framework\Actions\ServiceActions\HasMarkdownFeatures
 */
class HasMarkdownFeaturesTest extends TestCase
{
    use HasMarkdownFeatures;

    public function test_has_table_of_contents()
    {
        $this->assertIsBool(static::hasTableOfContents());

        Config::set('hyde.documentationPageTableOfContents.enabled', true);
        $this->assertTrue(static::hasTableOfContents());

        Config::set('hyde.documentationPageTableOfContents.enabled', false);
        $this->assertFalse(static::hasTableOfContents());
    }
}
