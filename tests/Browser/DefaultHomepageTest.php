<?php

namespace Hyde\Testing\Browser;

use Hyde\Testing\DuskTestCase;
use Laravel\Dusk\Browser;

class DefaultHomepageTest extends DuskTestCase
{
    public function testDefaultHomepageIsWelcomePage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('You\'re running on')
                    ->assertSee('HydePHP');
        });
    }
}
