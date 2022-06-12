<?php

namespace Hyde\Rocket\Http\Controllers;

use Hyde\Framework\Models\MarkdownPost;
use Hyde\Rocket\Models\Project;
use Hyde\Framework\Services\CollectionService;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        return view('dashboard', [
            'project' => Project::get(),
            'pages' => $this->getContentList(),
            'posts' => MarkdownPost::getLatestPosts(),
        ]);
    }

    protected function getContentList(): array
    {
        return array_merge([
           'Blade Pages' => CollectionService::getBladePageList(),
           'Markdown Pages' => CollectionService::getMarkdownPageList(),
           'Markdown Posts' => CollectionService::getMarkdownPostList(),
           'Documentation Pages' => CollectionService::getDocumentationPageList(),
        ]);
    }
}
