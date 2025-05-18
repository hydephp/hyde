<?php

declare(strict_types=1);

namespace Hyde\Testing;

use Hyde\Hyde;

class DefaultContentTest extends UnitTestCase
{
    public static function setUpBeforeClass(): void
    {
        self::resetKernel();
    }

    public function testDefaultPagesArePresent()
    {
        $this->assertFileExists(Hyde::path('_pages/index.blade.php'));
        $this->assertFileExists(Hyde::path('_pages/404.blade.php'));

        $this->assertStringContainsString(
            '<title>Welcome to HydePHP!</title>',
            file_get_contents(Hyde::path('_pages/index.blade.php'))
        );

        $this->assertStringContainsString(
            '<title>404 - Page not found</title>',
            file_get_contents(Hyde::path('_pages/404.blade.php'))
        );
    }

    public function testDefaultCompiledStylesheetIsPresent()
    {
        $this->assertFileExists(Hyde::path('_media/app.css'));

        $contents = file_get_contents(Hyde::path('_media/app.css'));

        $this->assertStringContainsString('--tw-', $contents);
        $this->assertStringContainsString('--tw-prose-', $contents);
    }

    public function testLaravelMixResourcesArePresent()
    {
        $this->assertFileExists(Hyde::path('resources/assets/app.css'));
        $this->assertFileExists(Hyde::path('resources/assets/app.js'));

        $this->assertFileContainsString("@import 'tailwindcss'", Hyde::path('resources/assets/app.css'));
        $this->assertFileContainsString('This is the main JavaScript', Hyde::path('resources/assets/app.js'));
    }

    protected function assertFileContainsString(string $string, string $file)
    {
        $this->assertStringContainsString($string, file_get_contents($file));
    }
}
