<?php


use Hyde\Framework\Hyde;
use Tests\TestCase;

class HydeUriPathHelperTest extends TestCase
{
    public function testHelperReturnsFalseWhenNoSiteUrlIsSet()
    {
        \Illuminate\Support\Facades\Config::set('hyde.site_url');
        $this->assertFalse(Hyde::uriPath());
    }

    public function testHelperReturnsExpectedStringWhenSiteUrlIsSet()
    {
        \Illuminate\Support\Facades\Config::set('hyde.site_url', 'https://example.com');
        $this->assertEquals('https://example.com/foo/bar.html', Hyde::uriPath('foo/bar.html'));
    }
}
