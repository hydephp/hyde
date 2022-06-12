<?php

if ($_SERVER['REMOTE_ADDR'] !== '::1')
{
    header('HTTP/1.1 403 Forbidden');
    echo '<h1>HTTP/1.1 403 - Access Denied</h1>';
    echo '<p>You must be on localhost to access this page. Refusing to serve request.</p>';
    exit;
}

// Load the same autoloader as the project
require_once sprintf('%s/vendor/autoload.php', BASE_PATH);

use Hyde\Framework\Exceptions\FileNotFoundException;
use Hyde\Framework\Exceptions\UnsupportedPageTypeException;
use Hyde\Framework\Hyde;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\DocumentationPage;
use Hyde\Framework\Models\MarkdownPage;
use Hyde\Framework\Models\MarkdownPost;
use Hyde\Framework\Services\CollectionService;

const VERSION = 'dev-master';

// Run the dashboard app
try {

// Create the Laravel app, and boot it up
try {
   $app = require_once sprintf('%s/app/bootstrap.php', BASE_PATH);
} catch (\Throwable $th) {
   try {
      $app = require_once sprintf('%s/bootstrap/app.php', BASE_PATH);
   } catch (\Throwable $th) {
      throw $th;
   }
}
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
Hyde::setBasePath(BASE_PATH);

// Create the Hyde interface
$hyde = new class() extends Hyde {};

// Create the project configuration class
$project = new class
{
    public string $path;
    public string $name;

    public function __construct()
    {
        $this->path = BASE_PATH;
        $this->name = config('hyde.name', ucwords(str_replace('-', ' ', basename(BASE_PATH))));
	}
};

// Set the app name
$appname = e($project->name) . ' CMS';


// Get the request page
$page = $_GET['page'] ?? 'index';
if ($page === 'dashboard' || $page === '' ) {
   $page = 'index';
}

// Key => label
$routes = [
   'index' => 'Dashboard',
   '404' => '404 Page Not Found',
   'manual'=> 'Manual',
   'file-viewer' => 'File Viewer',
];

if (! isset($routes[$page])) {
   header('HTTP/1.1 404 Not Found');
   $page = '404';
}

// Set the page name
$pagename = $appname .' - '. $routes[$page];

// Helper functions
function icon(string $name) {
   $icons = [
      'blade' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAQMAAAAlPW0iAAAACXBIWXMAAAPoAAAD6AG1e1JrAAAABlBMVEX/LR//LB96KezJAAAAAnRSTlN3CW8xmq0AAAA7SURBVAjXATAAz/8Ax/8AOfcAGcMARZwAbYgAbaYAbbYAbBEAbOMAY8cAZzcAcHcAPecAzZ8A8H8A+P+i4xJQuZ3gxwAAAABJRU5ErkJggg==',
      'markdown' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAKAQMAAACHcEzfAAAACXBIWXMAAAPoAAAD6AG1e1JrAAAABlBMVEVCQkJBQUFtOGGCAAAAAnRSTlPBCd2uk5MAAAAiSURBVAjXY2BgYKj/x+D3jMEljcEBiJwY/NIY/P6BBBkYAHYfCAEd79fPAAAAAElFTkSuQmCC',
      'documentation' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAQMAAAAlPW0iAAAACXBIWXMAAAPoAAAD6AG1e1JrAAAABlBMVEVXV1dUVFSxYS6RAAAAAnRSTlPnEHobuHcAAAArSURBVAjXY/j/nwGIHsgzPPBneJDO8KCc4QEzCD1+zPD4MJQBEXnADlQJABfcFU91j91PAAAAAElFTkSuQmCC',
   ];

   return $icons[$name] ?? '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="" />
<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
<!-- Created with the Bootstrap Dashboard Template https://getbootstrap.com/docs/5.1/examples/dashboard/ -->
<title><?= $pagename ?></title>
<!-- Bootstrap core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
<!-- Dashboard CSS -->
<meta name="theme-color" content="#7952b3" /> <style> .bd-placeholder-img { font-size: 1.125rem; text-anchor: middle; -webkit-user-select: none; -moz-user-select: none; user-select: none; } @media (min-width: 768px) { .bd-placeholder-img-lg { font-size: 3.5rem; } } </style>
<style> body { font-size: .875rem; } .feather { width: 16px; height: 16px; vertical-align: text-bottom; } /* * Sidebar */ .sidebar { position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; /* Behind the navbar */ padding: 48px 0 0; /* Height of navbar */ box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1); } @media (max-width: 767.98px) { .sidebar { top: 5rem; } } .sidebar-sticky { position: relative; top: 0; height: calc(100vh - 48px); padding-top: .5rem; overflow-x: hidden; overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */ } .sidebar .nav-link { font-weight: 500; color: #333; } .sidebar .nav-link .feather { margin-right: 4px; color: #727272; } .sidebar .nav-link.active { color: #2470dc; } .sidebar .nav-link:hover .feather, .sidebar .nav-link.active .feather { color: inherit; } .sidebar-heading { font-size: .75rem; text-transform: uppercase; } /* * Navbar */ .navbar-brand { padding-top: .75rem; padding-bottom: .75rem; font-size: 1rem; background-color: rgba(0, 0, 0, .25); box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25); } .navbar .navbar-toggler { top: .25rem; right: 1rem; } .navbar .form-control { padding: .75rem 1rem; border-width: 0; border-radius: 0; } .form-control-dark { color: #fff; background-color: rgba(255, 255, 255, .1); border-color: rgba(255, 255, 255, .1); } .form-control-dark:focus { border-color: transparent; box-shadow: 0 0 0 3px rgba(255, 255, 255, .25); } </style>
<style>/* Custom */
   .card { padding: 1rem; margin: 1rem; margin-bottom: 1.5rem; border-radius: .5rem; box-shadow: 0 0.5rem 0.75rem rgba(0, 0, 0, .125); }
   body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
   }  
   #main-content-wrapper {
      flex: 1;
   } 
   footer a.nav-link {
      color: #6c757d;
      padding: .25rem .5rem;
   }
   .table-secondary {
      background-color: #eee;
      --bs-table-bg: #eee;
   }
   th {
      color: #333;
   }
   .table>:not(:first-child) {
      border-top: 1.1px solid #999;
   }
</style>
</head>
<body>
   <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="dashboard.php">
         <?= $appname ?>
      </a>
      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-nav">
         <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="../">Back to site</a>
         </div>
      </div>
   </header>
   <div id="main-content-wrapper" class="container-fluid">
      <div class="row">
         <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
               <ul class="nav flex-column">
                  <li class="nav-item">
                     <a <?= $page === 'index' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>" href="dashboard.php">
                        <span data-feather="home"></span>
                        Dashboard
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">
                     <span data-feather="file"></span>
                     Orders
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">
                     <span data-feather="shopping-cart"></span>
                     Products
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">
                     <span data-feather="users"></span>
                     Customers
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">
                     <span data-feather="bar-chart-2"></span>
                     Reports
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">
                     <span data-feather="layers"></span>
                     Integrations
                     </a>
                  </li>
               </ul>
               <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>Saved reports</span>
                  <a class="link-secondary" href="#" aria-label="Add a new report">
                  <span data-feather="plus-circle"></span>
                  </a>
               </h6>
               <ul class="nav flex-column mb-2">
                  <li class="nav-item">
                     <a class="nav-link" href="#">
                     <span data-feather="file-text"></span>
                     Current month
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">
                     <span data-feather="file-text"></span>
                     Last quarter
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">
                     <span data-feather="file-text"></span>
                     Social engagement
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">
                     <span data-feather="file-text"></span>
                     Year-end sale
                     </a>
                  </li>
               </ul>
            </div>
         </nav>
         <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 px-xl-5 pt-xl-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
               <h1 class="h2"><?= $pagename ?></h1>
            </div>

               <?php if ($page === 'index'): ?>
                  <h2 class="h3">
                     Project Information
                  </h2>
                  <div class="d-flex flex-wrap -mx-3 pt-2">
                     <div class="col-12 col-sm-10 col-xl-8 col-xxl-6">
                        <div class="table-responsive">
                           <section class="card">
                              <h3 class="h5">Installation Details</h3>
                              <table class="table">
                                 <thead class="table-secondary">
                                    <tr>
                                       <th scope="col">Project Name</th>
                                       <th scope="col">Project Path</th>
                                       <th scope="col">Framework Version</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                        <td><?= e($project->name) ?></td>
                                        <td><?= e($project->path) ?></td>
                                        <td><?= e($hyde->version()) ?></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </section>
                           <section class="card">
                              <h3 class="h5">Content Overview</h3>
                              <table class="table">
                                 <thead class="table-secondary">
                                    <tr>
                                       <th scope="col">Blade Pages</th>
                                       <th scope="col">Markdown Pages</th>
                                       <th scope="col">Documentation Pages</th>
                                       <th scope="col">Blog Posts</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                   <tr>
                                       <td><?= count(CollectionService::getBladePageList()) ?> pages</td>
                                       <td><?= count(CollectionService::getMarkdownPageList()) ?> pages</td>
                                       <td><?= count(CollectionService::getDocumentationPageList()) ?> pages</td>
                                       <td><?= count(CollectionService::getMarkdownPostList()) ?> posts</td>
                                   </tr>
                                 </tbody>
                              </table>
                           </section>
                           <section class="card">
                              <?php
                                    $documentation = CollectionService::getDocumentationPageList();
                                    $posts = CollectionService::getMarkdownPostList();
                              ?>
                              <h3 class="h5">Your Pages</h3>
                              <table class="table">
                                 <thead class="table-secondary">
                                    <tr>
                                          <th scope="col">Type</th>
                                          <th scope="col">Page Name</th>
                                          <th scope="col">File Path</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php foreach (BladePage::all() as $page): ?>
                                       <tr>
                                          <th scope="row">
                                             <img width="16" height="16" src="<?= icon('blade') ?>" alt="" role="presentation">
                                             Blade
                                          </th>
                                          <td>
                                             <a title="View with realtime compiler" href="<?= Hyde::pageLink($page->slug . '.html') ?>"><?= $page->view ?></a>
                                          </td>
                                          <td>
                                             <a title="Open in CMS file manager" href="?page=file-viewer&type=bladepage&file=<?= urlencode($page->view) ?>"><?= BladePage::$sourceDirectory .'/'. $page->view . BladePage::$fileExtension ?></a>
                                          </td>
                                       </tr>
                                    <?php endforeach ?>
                                 </tbody>
                                 <tbody>
                                    <?php foreach (MarkdownPage::all() as $page): ?>
                                       <tr>
                                          <th scope="row">
                                             <img width="16" height="16" src="<?= icon('markdown') ?>" alt="" role="presentation">
                                             Markdown
                                          </th>
                                          <td>
                                             <a title="View with realtime compiler" href="<?= Hyde::pageLink($page->slug . '.html') ?>"><?= $page->title ?></a>
                                          </td>
                                          <td>
                                             <a title="Open in CMS file manager" href="?page=file-viewer&type=markdownpage&file=<?= urlencode($page->slug) ?>"><?= MarkdownPage::$sourceDirectory .'/'. $page->slug . MarkdownPage::$fileExtension ?></a>
                                          </td>
                                       </tr>
                                    <?php endforeach ?>
                                 </tbody>
                              </table>
                           </section>
                        </div>
                     </div>
                  </div>
               <?php elseif ($page === 'manual'): ?>
                  <article>
                     <pre><?= e(file_get_contents(__DIR__.'/dashboard-manual.txt')) ?></pre>
                  </article>
               <?php elseif ($page === 'file-viewer'): ?>
                  <div>
                     <?php
                        $editor = new class($_GET['type'], $_GET['file']) {
                           public string $filename;
                           public string $contentpath;
                           public string $type;
                           protected string $filepath;

                           public function __construct(string $type, string $file) {
                              $this->type = $this->qualifyType($type);
                              $this->filename = urldecode($file);
                              $this->contentpath = $this->getContentpath();
                              $this->filepath = Hyde::path($this->contentpath);
                           }

                           protected function qualifyType(string $type) {
                              $type = strtolower($type);
                              if ($type === 'bladepage') {
                                 return BladePage::class;
                              } elseif ($type === 'markdownpage') {
                                 return MarkdownPage::class;
                              } elseif ($type === 'documentationpage') {
                                 return DocumentationPage::class;
                              } elseif ($type === 'markdownpost') {
                                 return MarkdownPost::class;
                              } else {
                                 throw new UnsupportedPageTypeException('Invalid file type');
                              }
                           }

                           protected function getContentpath() {
                              $class = $this->type;
                              $filename = $this->filename;
                              $filepath = $class::$sourceDirectory .'/'. $filename . $class::$fileExtension;
                              if (!file_exists(Hyde::path($filepath))) {
                                 throw new FileNotFoundException($filepath);
                              }
                              return $filepath;
                           }

                           public function getContents() {
                              return file_get_contents($this->filepath);
                           }
                        };
                     ?>

                     <section class="col-12 col-xl-10 col-xxl-8">
                        <h3 class="h6 my-3">Showing file <code><?= e($editor->contentpath) ?></code></h3>
                  
                           <header class="bg-dark rounded-top d-flex align-items-center justify-content-between">
                              <ul class="nav nav-pills" id="pills-tab" role="tablist" type="toolbar">
                                 <li class="nav-item" role="presentation" title="View file">
                                    <button class="nav-link  text-light active" id="pills-view-tab" data-bs-toggle="pill" data-bs-target="#pills-view" type="button" role="tab" aria-controls="pills-view" aria-selected="true">
                                       View Source
                                    </button>
                                 </li>
                                 <li class="nav-item" role="presentation" title="Basic text editor">
                                    <button class="nav-link  text-light" id="pills-compiled-tab" data-bs-toggle="pill" data-bs-target="#pills-compiled" type="button" role="tab" aria-controls="pills-compiled" aria-selected="false">
                                       Live Preview
                                    </button>
                                 </li>
                              </ul>
                           </header>
                           <div class="tab-content" id="pills-tabContent">
                              <div class="tab-pane fade show active" id="pills-view" role="tabpanel" aria-labelledby="pills-view-tab">
                                 <pre ><code id="filecontents" class="language-<?= $editor->type === BladePage::class ? 'html' : 'markdown' ?>"><?= e($editor->getContents()) ?></code></pre>
                              </div>
                              <div class="tab-pane fade" id="pills-compiled" role="tabpanel" aria-labelledby="pills-compiled-tab">
                                 <iframe loading="lazy" width="100%" height="100%" style="min-height: 600px;" src="<?= Hyde::pageLink($editor->filename . '.html') ?>" frameborder="0">
                                 Loading...
                              </iframe>
                           </div>
                           </div>

                           <div>
                           <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/styles/default.min.css">
                           <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/highlight.min.js"></script>

                              <script>
                                 hljs.highlightElement(filecontents);
                              </script>
                        </div>
                     </section>
                     <?php unset($editor); ?>
                  </div>
                  
               <?php elseif ($page === '404'): ?>
                  Go <a href="dashboard.php">Back to dashboard</a>?
               <?php endif ?>
         </main>
      </div>
   </div>

   <div class="col-md-9 ms-md-auto col-lg-10 ">
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-4 border-top">
         <div class="col-md-6 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
            <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
            </a>
            <span class="text-muted">HydeCMS <?= VERSION ?></span>
                  <small class="text-muted ms-4">
                     This page was generated in <?= number_format((microtime(true) - HYDE_START) * 1000, 2) ?>ms.
                  </small>
         </div>
         <div class="col-md-6 text-end justify-content-end px-4 d-flex align-items-center">
           <ul class="nav">
             <li class="nav-item"> <a href="?page=manual" class="nav-link">Manual</a></li>
             <li class="nav-item"> <a href="" class="nav-link">GitHub</a></li>
           </ul>
         </div>
      </footer>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<!-- Dashboard scripts -->
<script> /* feather:false */ (function() { 'use strict'; feather.replace({ 'aria-hidden': 'true' }) })() </script>
</body>
</html>

<?php

} catch (\Throwable $th) {
	echo '<h1>Error</h1>';
	echo '<p>An error occurred while processing your request.</p>';
	echo '<pre><code>'.$th->getMessage().'</code></pre>';
	echo '<p>Extra information:</p>';
	echo '<pre><code>'.$th->getTraceAsString().print_r($th, true).'</code></pre>';
	exit($th->getCode());
}
