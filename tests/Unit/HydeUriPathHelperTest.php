<?php

use Hyde\Framework\Hyde;
use Tests\TestCase;

class HydeUriPathHelperTest extends TestCase
{
    public function test_helper_returns_false_when_no_site_url_is_set()
    {
        \Illuminate\Support\Facades\Config::set('hyde.site_url');
        $this->assertFalse(Hyde::uriPath());
    }

    public function test_helper_returns_expected_string_when_site_url_is_set()
    {
        \Illuminate\Support\Facades\Config::set('hyde.site_url', 'https://example.com');
        $this->assertEquals('https://example.com/foo/bar.html', Hyde::uriPath('foo/bar.html'));
    }
}
