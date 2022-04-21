<?php

namespace Tests\Unit;

use Hyde\Framework\Hyde;
use Tests\TestCase;

class HydeVendorPathHelperTest extends TestCase
{
    public function test_method_exists()
    {
        $this->assertTrue(method_exists('Hyde', 'vendorPath'));
    }

    public function test_method_returns_string()
    {
        $this->assertIsString(Hyde::vendorPath());
    }

    public function test_method_returns_string_containing_vendor_path()
    {
        $this->assertStringContainsString('vendor', Hyde::vendorPath());
    }

    public function test_method_returns_path_to_the_vendor_directory()
    {
        $this->assertDirectoryExists(Hyde::vendorPath());
        $this->assertFileExists(Hyde::vendorPath().'/composer.json');
        $this->assertStringContainsString('"name": "hyde/framework",', file_get_contents(Hyde::vendorPath().'/composer.json'));
    }

    public function test_method_returns_qualified_file_path_when_supplied_with_argument()
    {
        $this->assertEquals(Hyde::vendorPath('file.php'), Hyde::vendorPath().'/file.php');
    }

    public function test_method_returns_expected_value_regardless_of_trailing_directory_separators_in_argument()
    {
        $this->assertEquals(Hyde::vendorPath('\\/file.php/'), Hyde::vendorPath().'/file.php');

        $this->assertEquals(Hyde::vendorPath('directory/file.php'), Hyde::vendorPath().'/directory/file.php');
        $this->assertEquals(Hyde::vendorPath('directory/file.php/'), Hyde::vendorPath().'/directory/file.php');
        $this->assertEquals(Hyde::vendorPath('/directory/file.php/'), Hyde::vendorPath().'/directory/file.php');
        $this->assertEquals(Hyde::vendorPath('\\/directory/file.php/'), Hyde::vendorPath().'/directory/file.php');

        $this->assertEquals(Hyde::vendorPath('\\/directory/file.php/'), Hyde::vendorPath().'/directory/file.php');
        $this->assertEquals(Hyde::vendorPath('/directory/file.php/'), Hyde::vendorPath().'/directory/file.php');
        $this->assertEquals(Hyde::vendorPath('\\/directory/file.php/'), Hyde::vendorPath().'/directory/file.php');

        $this->assertEquals(Hyde::vendorPath('\\/directory/file.php/'), Hyde::vendorPath().'/directory/file.php');
        $this->assertEquals(Hyde::vendorPath('/directory/file.php/'), Hyde::vendorPath().'/directory/file.php');
        $this->assertEquals(Hyde::vendorPath('\\/directory/file.php/'), Hyde::vendorPath().'/directory/file.php');
    }
}
