<?php

namespace Tests\Unit;

use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class HydeSafeCopyHelperTest extends TestCase
{
    protected static function testDir(string $path = ''): string
    {
        return __DIR__ . 'HydeSafeCopyHelperTestTemp' . $path;
    }

    public function setUp(): void
    {
        parent::setUp();

        mkdir(static::testDir());
    }

    public function testCopyMethodExists()
    {
        $this->assertTrue(method_exists(Hyde::class, 'copy'));
    }

    public function testCopyMethodReturns404IfSourceFileDoesNotExist()
    {
        $this->assertEquals(404,
            Hyde::copy(static::testDir('/does/not/exist.txt'),  static::testDir('/test.txt'))
        );
    }

    public function testCopyMethodReturns409IfDestinationFileExistsAndForceFlagIsNotSet()
    {
        file_put_contents(static::testDir('/test.txt'), 'test');

        $this->assertEquals(409,
            Hyde::copy(static::testDir('/test.txt'),  static::testDir('/test.txt'))
        );

        unlink(static::testDir('/test.txt'));
    }

    public function testCopyMethodReturnsTrueIfDestinationFileExistsAndForceFlagIsSet()
    {
        file_put_contents(static::testDir('/foo.txt'), 'foo');

        $this->assertTrue(
            Hyde::copy(static::testDir('/foo.txt'),  static::testDir('/bar.txt'), true)
        );

        unlink(static::testDir('/foo.txt'));
        unlink(static::testDir('/bar.txt'));
    }

    public function testFileWithNoConflictsIsCopied()
    {
        file_put_contents(static::testDir('/foo.txt'), 'foo');

        $this->assertTrue(
            Hyde::copy(static::testDir('/foo.txt'),  static::testDir('/bar.txt'))
        );

        $this->assertFileExists(static::testDir('/bar.txt'));
    }

    public function testFileWithConflictsIsNotCopiedWhenForceFlagIsNotSet()
    {
        file_put_contents(static::testDir('/foo.txt'), 'foo');
        file_put_contents(static::testDir('/bar.txt'), 'bar');

        $this->assertEquals(409,
            Hyde::copy(static::testDir('/foo.txt'),  static::testDir('/bar.txt'))
        );

        $this->assertStringEqualsFile(static::testDir('/bar.txt'), 'bar');
    }

    public function testFileWithConflictsIsCopiedWhenForceFlagIsSet()
    {
        file_put_contents(static::testDir('/foo.txt'), 'foo');
        file_put_contents(static::testDir('/bar.txt'), 'bar');

        $this->assertTrue(
            Hyde::copy(static::testDir('/foo.txt'),  static::testDir('/bar.txt'), true)
        );

        $this->assertStringEqualsFile(static::testDir('/bar.txt'), 'foo');
    }

    public function tearDown(): void
    {
        File::deleteDirectory(static::testDir());

        parent::tearDown();
    }
}
