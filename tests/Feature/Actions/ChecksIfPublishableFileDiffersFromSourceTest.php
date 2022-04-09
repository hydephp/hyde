<?php

namespace Tests\Feature\Actions;

use Hyde\Framework\Actions\ChecksIfPublishableFileDiffersFromSource as Action;
use Hyde\Framework\Hyde;
use Tests\TestCase;

class ChecksIfPublishableFileDiffersFromSourceTest extends TestCase
{
    public function test_it_can_parse_the_data_file()
    {
        $filecache = Action::getFilecache();

        $this->assertIsArray($filecache);

        $entry = current($filecache);
        $this->assertIsString($entry['md5sum']);
        $this->assertIsInt($entry['last_modified']);
    }

    public function test_it_returns_true_if_the_file_differs_from_the_source()
    {
        touch(__DIR__.'/test.temp');

        $action = new Action(__DIR__.'/test.temp', 'resources/views/layouts/app.blade.php');

        $this->assertTrue($action->execute());
    }

    public function test_it_returns_false_if_the_file_is_the_same_as_the_source()
    {
        copy(Hyde::vendorPath('resources/views/layouts/app.blade.php'), __DIR__.'/test.temp');
        $action = new Action(__DIR__.'/test.temp', 'resources/views/layouts/app.blade.php');

        $this->assertFalse($action->execute());
    }

    public function test_it_returns_null_if_the_file_does_not_exist_in_cache()
    {
        touch(__DIR__.'/test.temp');

        $action = new Action(__DIR__.'/test.temp', '/foo/bar/file.php');

        $this->assertNull($action->execute());
    }

    public function test_it_returns_null_if_the_supplied_file_does_not_exist_on_disk()
    {
        $action = new Action('/foo/bar/file.php');

        $this->assertNull($action->execute());
    }

    public function tearDown(): void
    {
        if (file_exists(__DIR__.'/test.temp')) {
            unlink(__DIR__.'/test.temp');
        }

        parent::tearDown();
    }
}
