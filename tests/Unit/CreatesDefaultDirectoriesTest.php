<?php

namespace Tests\Unit;

use Hyde\Framework\Actions\CreatesDefaultDirectories;
use Hyde\Framework\Hyde;
use Tests\TestCase;

class CreatesDefaultDirectoriesTest extends TestCase
{
    /**
     * Test if the directories are created.
     *
     * Note that the action is called by the Service Provider
     * when booting, so we don't call the action directly.
     *
     * To properly test that it works, you should first
     * remove the directories manually as the action
     * will not have anything to do otherwise.
     *
     * @return void
     */
    public function test_default_directories_are_created()
    {
        foreach (CreatesDefaultDirectories::getRequiredDirectories() as $directory) {
            $this->assertTrue(is_dir(Hyde::path($directory)));
        }
    }
}
