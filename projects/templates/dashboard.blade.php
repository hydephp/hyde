@php
    use Hyde\Framework\Models\BladePage;
    use Hyde\Framework\Models\MarkdownPage;
    use Hyde\Framework\Models\DocumentationPage;
    use Hyde\Framework\Models\MarkdownPost;
    use Hyde\Framework\Services\CollectionService;

	$github = new class {
		public bool $enabled;

		public function __construct() {
			$this->enabled = (config('hyde.github_dashboard.enabled', false) === true)
				&& (config('hyde.github_dashboard.username') !== null)
				&& (config('hyde.github_dashboard.repository') !== null)
				&& (config('hyde.github_dashboard.branch') !== null);
		}

		public function getLink(string $path): string {
            $action = config('hyde.github_dashboard.action', 'view') === 'edit' ? 'edit' : 'blob';
            return sprintf("https://github.com/%s/%s/%s/%s/%s",
                config('hyde.github_dashboard.username'),
                config('hyde.github_dashboard.repository'),
                $action,
                config('hyde.github_dashboard.branch'),
                $path
            );
        }

        public function link(string $path): string {
            return $this->enabled
                ? '<a href="'.$this->getLink(e($path)).'">'.e($path).'</a>'
                : e($path);
        }
	};
@endphp

@extends('hyde::layouts.app')
@section('content')
    @php($title = "Dashboard")

    <style>
        .dashboard-table td, .dashboard-table th {
            width: 50%;
        }
        .table-justified td, .table-justified th {
            text-align: center;
        }
        .table-justified td:first-child, .table-justified th:first-child {
            text-align: left;
        }
        .table-justified td:last-child, .table-justified th:last-child {
            text-align: right;
        }
    </style>
    
    <main class="mx-auto max-w-7xl py-16 px-8">
        <header class="text-center prose dark:prose-invert mx-auto">
            <h1 class="text-3xl font-bold">Project Dashboard</h1>
            <p>
                <strong>
                    Here you can get a quick overview of your project.
                </strong>
            </p>
            <p>
                While this is useful when developing locally,
                you may not want to use it when compiling
                for production.
            </p>
        </header>

        <section class="prose dark:prose-invert mx-auto mt-8">
            <header>
                <h2>Project Details</h2>
            </header>

            <section class="mt-8">
                <h3>Installation Details</h3>
                <table class="table-justified">
                    <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Project Path</th>
                        <th>Framework Version</th>
                        <th>PHP Version</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ config('hyde.name', Hyde::titleFromSlug(basename(Hyde::path()))) }}</td>
                        <td>{{ Hyde::path() }}</td>
                        <td>{{ Hyde::version() }}</td>
                        <td>{{ PHP_VERSION }} <small>({{ PHP_SAPI }})</small></td>
                    </tr>
                    </tbody>
                </table>

                <h3>GitHub Integration</h3>
                <table class="table-justified">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Repository</th>
                        <th>Branch</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @if (config('hyde.github_dashboard.enabled', false))
                            <td>
                                <a href="https://github.com/{{ config('hyde.github_dashboard.username', '<not-set>') }}">
                                    {{ config('hyde.github_dashboard.username', '<not-set>') }}
                                </a>
                            </td>
                            <td>
                                <a href="https://github.com/{{ config('hyde.github_dashboard.username', '<not-set>') }}/{{ config('hyde.github_dashboard.repository', '<not-set>') }}">
                                    {{ config('hyde.github_dashboard.repository', '<not-set>') }}
                                </a>
                            </td>
                            <td>
                                <a href="https://github.com/{{ config('hyde.github_dashboard.username', '<not-set>') }}/{{ config('hyde.github_dashboard.repository', '<not-set>') }}/tree/{{ config('hyde.github_dashboard.branch', '<not-set>') }}">
                                    {{ config('hyde.github_dashboard.branch', '<not-set>') }}
                                </a>
                            </td>
                        @else
                            <td colspan="4">
                                <p class="text-center mb-0">
                                    <strong>
                                        GitHub Dashboard Integrations is not enabled.
                                    </strong>
                                </p>
                                <details class="text-center">
                                    <summary class="cursor-pointer">
                                        Show configuration guide.
                                    </summary>
                                    <p>
                                        The GitHub integration allows you to easily
                                        open dashboard files in your GitHub repository.
                                        <br>
                                        To enable it, you need to let Hyde know where
                                        your GitHub repository is located.<br>
                                        The repository is assumed to be a top level installation of Hyde/Hyde.
                                        <br>
                                        Add the following to your <code>config/hyde.php</code> file:
                                    </p>
                                    <pre class="text-left w-fit py-0 px-4 mx-auto"><code class="my-0"><div style="color: rgb(191, 199, 213); font-family: 'Fira Code Regular', Consolas, 'Courier New', monospace; font-size: 14px; line-height: 18px;"><div style="line-height: 18px;"><div><span style="color: #d9f5dd;">'</span><span style="color: #c3e88d;">github_dashboard</span><span style="color: #d9f5dd;">'</span> <span style="color: #89ddff;">=&gt;</span> [</div><div>&nbsp; &nbsp; <span style="color: #d9f5dd;">'</span><span style="color: #c3e88d;">enabled</span><span style="color: #d9f5dd;">'</span> <span style="color: #89ddff;">=&gt;</span> <span style="color: #82aaff;">true</span>,</div><div>&nbsp; &nbsp; <span style="color: #d9f5dd;">'</span><span style="color: #c3e88d;">username</span><span style="color: #d9f5dd;">'</span> <span style="color: #89ddff;">=&gt;</span> <span style="color: #d9f5dd;">'</span><span style="color: #c3e88d;">octocat</span><span style="color: #d9f5dd;">'</span>,</div><div>&nbsp; &nbsp; <span style="color: #d9f5dd;">'</span><span style="color: #c3e88d;">repository</span><span style="color: #d9f5dd;">'</span> <span style="color: #89ddff;">=&gt;</span> <span style="color: #d9f5dd;">'</span><span style="color: #c3e88d;">homepage</span><span style="color: #d9f5dd;">'</span>,</div><div>&nbsp; &nbsp; <span style="color: #d9f5dd;">'</span><span style="color: #c3e88d;">branch</span><span style="color: #d9f5dd;">'</span> <span style="color: #89ddff;">=&gt;</span> <span style="color: #d9f5dd;">'</span><span style="color: #c3e88d;">main</span><span style="color: #d9f5dd;">'</span>,</div><div>]</div></div></div></code></pre>
                                </details>
                            </td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </section>
        </section>

        <section class="prose dark:prose-invert mx-auto mt-8">
            <header>
                <h2>Your Content</h2>
            </header>
        
            <h3>Content Overview</h3>
            <table class="table-justified">
                <thead>
                <tr>
                    <th>Blade Pages</th>
                    <th>Markdown Pages</th>
                    <th>Documentation Pages</th>
                    <th>Blog Posts</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <a href="#blade-pages">
                            <b>{{ count(CollectionService::getBladePageList()) }}</b> pages
                        </a>
                    </td>
                    <td>
                        <a href="#markdown-pages">
                            <b>{{ count(CollectionService::getMarkdownPageList()) }}</b> pages
                        </a>
                    </td>
                    <td>
                        <a href="#documentation-pages">
                            <b>{{ count(CollectionService::getDocumentationPageList()) }}</b> pages
                        </a>
                    </td>
                    <td>
                        <a href="#blog-posts">
                            <b>{{ count(CollectionService::getMarkdownPostList()) }}</b> posts
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>

            <section class="mt-8">
                <h3 id="blade-pages">
                    Blade Pages
                    <a href="#blade-pages" title="Heading link">#</a>
                </h3>
                <table class="dashboard-table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Source File</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (BladePage::all() as $page)
                        <tr>
                            <td>
                                <a href="{{ Hyde::pageLink($page->slug . '.html') }}">
                                    {{ Hyde::titleFromSlug($page->view) }}
                                </a>
                            </td>
                            <td>
                                {!! $github->link(BladePage::$sourceDirectory .'/'. $page->slug . BladePage::$fileExtension) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>

            <section class="mt-8">
                <h3 id="markdown-pages">
                    Markdown Pages
                    <a href="#markdown-pages" title="Heading link">#</a>
                </h3>
                <table class="dashboard-table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Source File</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (MarkdownPage::all() as $page)
                        <tr>
                            <td>
                                <a href="{{ Hyde::pageLink($page->slug . '.html') }}">
                                    {{ $page->title }}
                                </a>
                            </td>
                            <td>
                                {!! $github->link(MarkdownPage::$sourceDirectory .'/'. $page->slug . MarkdownPage::$fileExtension) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>

            <section class="mt-8">
                <h3 id="documentation-pages">
                    Documentation Pages
                    <a href="#documentation-pages" title="Heading link">#</a>
                </h3>
                <table class="dashboard-table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Source File</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (DocumentationPage::all() as $page)
                        <tr>
                            <td>
                                <a href="{{ Hyde::docsDirectory() .'/'. Hyde::pageLink($page->slug . '.html') }}">
                                    {{ $page->title }}
                                </a>
                            </td>
                            <td>
                                {!! $github->link(DocumentationPage::$sourceDirectory .'/'. $page->slug . DocumentationPage::$fileExtension) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>

            <section class="mt-8">
                <h3 id="blog-posts">
                    Blog Posts
                    <a href="#blog-posts" title="Heading link">#</a>
                </h3>
                <table class="dashboard-table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Source File</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (MarkdownPost::all() as $post)
                        <tr>
                            <td>
                                <a href="posts/{{ Hyde::pageLink($post->slug . '.html') }}">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td>
                                {!! $github->link(MarkdownPost::$sourceDirectory .'/'. $post->slug . MarkdownPost::$fileExtension) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </section>
    </main>
@endsection
