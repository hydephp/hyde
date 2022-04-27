<?php

namespace Services;

use Hyde\Framework\Concerns\Markdown\HasConfigurableMarkdownFeatures;
use Hyde\Framework\Models\DocumentationPage;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * @covers \Hyde\Framework\Concerns\Markdown\HasConfigurableMarkdownFeatures
 */
class HasConfigurableMarkdownFeaturesTest extends TestCase
{
    use HasConfigurableMarkdownFeatures;

    private string $sourceModel;

    public function test_has_features_array()
    {
        $this->assertIsArray($this->features);
    }

    // Test that the features array is empty by default
    public function test_has_features_array_empty()
    {
        $this->assertEmpty($this->features);
    }

    // Test that features can be added to the array
    public function test_has_features_array_add()
    {
        $this->addFeature('test');
        $this->assertContains('test', $this->features);
    }

    // Test that features can be removed from the array
    public function test_has_features_array_remove()
    {
        $this->addFeature('test');
        $this->removeFeature('test');
        $this->assertNotContains('test', $this->features);
    }

    // Test that method chaining can be used to programmatically add features to the array
    public function test_has_features_array_add_chain()
    {
        $this->addFeature('test')->addFeature('test2');
        $this->assertContains('test', $this->features);
        $this->assertContains('test2', $this->features);
    }

    // Test that method chaining can be used to programmatically remove features from the array
    public function test_has_features_array_remove_chain()
    {
        $this->addFeature('test')->addFeature('test2')->removeFeature('test');
        $this->assertNotContains('test', $this->features);
        $this->assertContains('test2', $this->features);
    }

    // Test that method withTableOfContents method chain adds the table-of-contents feature
    public function test_has_features_array_add_toc()
    {
        $this->withTableOfContents();
        $this->assertContains('table-of-contents', $this->features);
    }

    // Test that method withPermalinks method chain adds the permalinks feature
    public function test_has_features_array_add_permalinks()
    {
        $this->withPermalinks();
        $this->assertContains('permalinks', $this->features);
    }

    // Test that hasFeature() returns true if the feature is in the array
    public function test_has_features_array_has()
    {
        $this->addFeature('test');
        $this->assertTrue($this->hasFeature('test'));
    }

    // Test that hasFeature() returns false if the feature is not in the array
    public function test_has_features_array_has_not()
    {
        $this->assertFalse($this->hasFeature('test'));
    }

    // Test that method canEnablePermalinks returns true if the permalinks feature is in the array
    public function test_has_features_array_can_enable_permalinks()
    {
        $this->addFeature('permalinks');
        $this->assertTrue($this->canEnablePermalinks());
    }

    // Test that method canEnablePermalinks is automatically for DocumentationPages
    public function test_has_features_array_can_enable_permalinks_auto()
    {
        Config::set('hyde.documentationPageTableOfContents.enabled', true);
        $this->sourceModel = DocumentationPage::class;

        $this->assertTrue($this->canEnablePermalinks());
    }

    // Test that method canEnablePermalinks returns false if the permalinks feature is not in the array
    public function test_has_features_array_can_enable_permalinks_not()
    {
        $this->assertFalse($this->canEnablePermalinks());
    }

    // Test that method canEnableTorchlight returns true if the torchlight feature is in the array
    public function test_has_features_array_can_enable_torchlight()
    {
        $this->addFeature('torchlight');
        $this->assertTrue($this->canEnableTorchlight());
    }

    // Test that method canEnableTorchlight returns false if the torchlight feature is not in the array
    public function test_has_features_array_can_enable_torchlight_not()
    {
        $this->assertFalse($this->canEnableTorchlight());
    }
}
