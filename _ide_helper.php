<?php  /** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

/**
 * @internal This file belongs to the HydePHP development repository,
 * and is not covered by the backward compatibility promise,
 * as it is not versioned through any official releases.
 *
 * When using a good IDE, such as PhpStorm, this file will be used to provide
 * rich code completion for "magic" fields, such as global data and facades.
 */

// Global page variables

/** @var \Hyde\Pages\Concerns\HydePage $page The page being compiled/previewed */
$page = \Hyde\Support\Facades\Render::getPage();

/** @var \Hyde\Support\Models\Route $currentRoute The route for the page being compiled/previewed */
$currentRoute = \Hyde\Support\Facades\Render::getCurrentRoute();

/** @var string $currentPage The route key for the page being compiled/previewed */
$currentPage = \Hyde\Support\Facades\Render::getCurrentPage();

// Facades (aliased in app/config.php)

/** @mixin \Hyde\Foundation\HydeKernel */
class Hyde extends \Hyde\Hyde {}
class Site extends \Hyde\Facades\Site {}
class Meta extends \Hyde\Facades\Meta {}
/** @mixin \Hyde\Framework\Services\AssetService */
class Asset extends \Hyde\Facades\Asset {}
class Author extends \Hyde\Facades\Author {}
class Features extends \Hyde\Facades\Features {}
class Config extends \Hyde\Facades\Config {}
/** @mixin \Illuminate\Filesystem\Filesystem */
class Filesystem extends \Hyde\Facades\Filesystem {}
class DataCollections extends \Hyde\Support\DataCollections {}
class Includes extends \Hyde\Support\Includes {}
/** @mixin \Hyde\Foundation\Kernel\RouteCollection */
class Routes extends \Hyde\Foundation\Facades\Routes {}

// Page classes (aliased in app/config.php)
class HtmlPage extends \Hyde\Pages\HtmlPage {}
class BladePage extends \Hyde\Pages\BladePage {}
class MarkdownPage extends \Hyde\Pages\MarkdownPage {}
class MarkdownPost extends \Hyde\Pages\MarkdownPost {}
class DocumentationPage extends \Hyde\Pages\DocumentationPage {}
