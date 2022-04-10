<?php

namespace Tests\Unit;

use Hyde\Framework\Hyde;
use Tests\TestCase;

class HydeSafeCopyHelperTest extends TestCase
{
    protected static function testDir(string $path = ''): string
    {
        return __DIR__.'HydeSafeCopyHelperTestTemp'.$path;
    }

    public function setUp(): void
    {
        parent::setUp();

        mkdir(static::testDir());
    }

    public function test_copy_method_exists()
    {
        $this->assertTrue(method_exists(Hyde::class, 'copy'));
    }

    public function test_copy_method_returns404_if_source_file_does_not_exist()
    {
        $this->assertEquals(
            404,
            Hyde::copy(static::testDir('/does/not/exist.txt'), static::testDir('/test.txt'))
        );
    }

    public function test_copy_method_returns409_if_destination_file_exists_and_force_flag_is_not_set()
    {
        file_put_contents(static::testDir('/test.txt'), 'test');

        $this->assertEquals(
            409,
            Hyde::copy(static::testDir('/test.txt'), static::testDir('/test.txt'))
        );

        unlink(static::testDir('/test.txt'));
    }

    public function test_copy_method_returns_true_if_destination_file_exists_and_force_flag_is_set()
    {
        file_put_contents(static::testDir('/foo.txt'), 'foo');

        $this->assertTrue(
            Hyde::copy(static::testDir('/foo.txt'), static::testDir('/bar.txt'), true)
        );

        unlink(static::testDir('/foo.txt'));
        unlink(static::testDir('/bar.txt'));
    }

    public function test_file_with_no_conflicts_is_copied()
    {
        file_put_contents(static::testDir('/foo.txt'), 'foo');

        $this->assertTrue(
            Hyde::copy(static::testDir('/foo.txt'), static::testDir('/bar.txt'))
        );

        $this->assertFileExists(static::testDir('/bar.txt'));
    }

    public function test_file_with_conflicts_is_not_copied_when_force_flag_is_not_set()
    {
        file_put_contents(static::testDir('/foo.txt'), 'foo');
        file_put_contents(static::testDir('/bar.txt'), 'bar');

        $this->assertEquals(
            409,
            Hyde::copy(static::testDir('/foo.txt'), static::testDir('/bar.txt'))
        );

        $this->assertStringEqualsFile(static::testDir('/bar.txt'), 'bar');
    }

    public function test_file_with_conflicts_is_copied_when_force_flag_is_set()
    {
        file_put_contents(static::testDir('/foo.txt'), 'foo');
        file_put_contents(static::testDir('/bar.txt'), 'bar');

        $this->assertTrue(
            Hyde::copy(static::testDir('/foo.txt'), static::testDir('/bar.txt'), true)
        );

        $this->assertStringEqualsFile(static::testDir('/bar.txt'), 'foo');
    }

    public function tearDown(): void
    {
        deleteDirectory(static::testDir());

        parent::tearDown();
    }
}
