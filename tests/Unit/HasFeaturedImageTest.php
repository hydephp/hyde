<?php

namespace Tests\Unit;

use Hyde\Framework\Concerns\HasFeaturedImage;
use Hyde\Framework\Models\Image;
use Tests\TestCase;

/**
 * Class HasFeaturedImageTest.
 *
 * @covers \Hyde\Framework\Concerns\HasFeaturedImage
 */
class HasFeaturedImageTest extends TestCase
{
    use HasFeaturedImage;

    protected array $matter;

    // Test it can create a new Image instance from a string
    public function test_it_can_create_a_new_image_instance_from_a_string()
    {
        $this->matter = [
            'image' => 'https://example.com/image.jpg',
        ];

        $this->constructFeaturedImage();
        $this->assertInstanceOf(Image::class, $this->image);
        $this->assertEquals('https://example.com/image.jpg', $this->image->uri);
    }

    // Test it can create a new Image instance from an array
    public function test_it_can_create_a_new_image_instance_from_an_array()
    {
        $this->matter = [
            'image' => [
                'uri' => 'https://example.com/image.jpg',
            ],
        ];

        $this->constructFeaturedImage();
        $this->assertInstanceOf(Image::class, $this->image);
        $this->assertEquals('https://example.com/image.jpg', $this->image->uri);
    }

    // Test constructBaseImage() sets the source to the image's uri when supplied path is an uri
    public function test_construct_base_image_sets_the_source_to_the_image_uri_when_supplied_path_is_an_uri()
    {
        $image = $this->constructBaseImage('https://example.com/image.jpg');
        $this->assertEquals('https://example.com/image.jpg', $image->getSource());
    }

    // Test constructBaseImage() sets the source to the image's path when supplied path is a local path
    public function test_construct_base_image_sets_the_source_to_the_image_path_when_supplied_path_is_a_local_path()
    {
        $image = $this->constructBaseImage('/path/to/image.jpg');
        $this->assertEquals('/path/to/image.jpg', $image->getSource());
    }

    // Test constructBaseImage() returns an Image instance created from a string
    public function test_construct_base_image_returns_an_image_instance_created_from_a_string()
    {
        $this->assertInstanceOf(Image::class, $this->constructBaseImage(''));
    }

    // Test constructFullImage() returns an Image instance created from an array
    public function test_construct_full_image_returns_an_image_instance_created_from_an_array()
    {
        $this->assertInstanceOf(Image::class, $this->constructFullImage([]));
    }
}
