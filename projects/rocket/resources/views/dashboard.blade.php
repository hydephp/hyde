@extends('partials.layout')

@section('content')
    <header>
        <h1>
            Welcome to Hyde Rocket!
        </h1>
    </header>
    <section id="project-overview" class="center">
        <h2>
            Project Overview
        </h2>
        <table>
            <caption>
                Project Information
            </caption>
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Project Path</th>
                    <th>Hyde Version</th>
                    @if($app->windows)
                        <th colspan="1">Open project directory in</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->path }}</td>
                    <td>{{ $project->version }}</td>
                    @if($app->windows)
                    <td>
                        <form action="/fileapi/open" method="POST">
                            <input type="hidden" name="path" value="">
                            <input type="hidden" name="back" value="{{ request()->path() }}">
                            <button type="submit">Windows Explorer</button>
                        </form>
                    </td>
                    @endif
                </tr>
            </tbody>
        </table>

        <table>
            <caption>
                Content Overview
            </caption>
            <thead>
                <tr>
                    @foreach($pages as $category => $group)
                        <th>{{ $category }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($pages as $category => $group)
                        <td>
                            <strong>{{ count($group) }}</strong>
                            {{ strtolower(explode(' ', $category)[1]) }}
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </section>


    <section id="pages-overview" class="center">
        <h2>
            Your Pages
        </h2>
        <table id="pages">
            <thead>
            <tr>
                <th colspan="2">Type</th>
                <th>Page</th>
                <th>Path</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody class="not-center">
                @foreach($pages['Blade Pages'] as $page)
                    <tr>
                        <td><img width="16" height="16" src="/icons/blade.svg" alt="" role="presentation"></td>
                        <td>Blade</td>
                        <td>{{ \Hyde\Framework\Hyde::titleFromSlug($page) }}</td>
                        <td>_pages/{{ $page }}.blade.php</td>
                        <td style="border-right: none; padding-right: 0.25rem;">
                            <form action="/fileapi/open" method="POST">
                                <input type="hidden" name="path" value="_pages/{{ $page }}.blade.php">
                                <input type="hidden" name="back" value="{{ request()->path() }}">
                                <button type="submit" title="Open in system editor" @disabled(! $app->windows)>Edit</button>
                            </form>
                        </td>
                        <td style="border-left: none; padding-left: 0.25rem;">
                            <form action="/open/_site" method="GET">
                                <input type="hidden" name="path" value="{{ $page }}.html">
                                <button type="submit" title="View with Realtime Compiler">View</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tbody class="not-center">
            @foreach($pages['Markdown Pages'] as $page)
                <tr>
                    <td><img width="16" height="16" src="/icons/markdown.svg" alt="" role="presentation"></td>
                    <td>Markdown</td>
                    <td>
                        <a href="/render/markdown?path={{ urlencode("_pages/$page.md")  }}" target="_blank" title="Open popup with compiled Markdown">
                            {{ \Hyde\Framework\Hyde::titleFromSlug($page) }}</td>
                        </a>
                    <td>_pages/{{ $page }}.md</td>
                    <td style="border-right: none; padding-right: 0.25rem;">
                        <form action="/fileapi/open" method="POST">
                            <input type="hidden" name="path" value="_pages/{{ $page }}.md">
                            <input type="hidden" name="back" value="{{ request()->path() }}">
                            <button type="submit" title="Open in system editor" @disabled(! $app->windows)>Edit</button>
                        </form>
                    </td>
                    <td style="border-left: none; padding-left: 0.25rem;">
                        <form action="/open/_site" method="GET">
                            <input type="hidden" name="path" value="{{ $page }}.html">
                            <button type="submit" title="View with Realtime Compiler">View</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tbody class="not-center">
            @foreach($pages['Documentation Pages'] as $page)
                <tr>
                    <td><img width="16" height="16" src="/icons/documentation.svg" alt="" role="presentation"></td>
                    <td>Documentation</td>
                    <td>{{ \Hyde\Framework\Hyde::titleFromSlug($page) }}</td>
                    <td>_docs/{{ $page }}.md</td>
                    <td style="border-right: none; padding-right: 0.25rem;">
                        <form action="/fileapi/open" method="POST">
                            <input type="hidden" name="path" value="_docs/{{ $page }}.md">
                            <input type="hidden" name="back" value="{{ request()->path() }}">
                            <button type="submit" title="Open in system editor" @disabled(! $app->windows)>Edit</button>
                        </form>
                    </td>
                    <td style="border-left: none; padding-left: 0.25rem;">
                        <form action="/open/_site" method="GET">
                            <input type="hidden" name="path" value="docs/{{ $page }}.html">
                            <button type="submit" title="View with Realtime Compiler">View</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

    <section id="posts-overview" class="center">
        <header style="margin-top: 2rem; margin-bottom: 1.5rem;">
            <h2 style="display: inline-block; margin: 1rem 0.5rem; line-height: 1rem;">
                Your Blog Posts
            </h2>
            <a href="/create-post" style="position: absolute; margin: 1rem 0.5rem; line-height: 1rem;">Create new</a>
        </header>
        <table id="posts">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody class="not-center">
                @php /** @var \Hyde\Framework\Models\MarkdownPost $post */ @endphp
                @foreach($posts as $post)
                    <tr>
                        <td>
                            <a href="/_posts/{{ $post->slug }}">{{ $post->title }}</a>
                        </td>
                        <td>{{ $post->author->getName() }}</td>
                        <td>{{ $post->category }}</td>
                        <td>{{ $post->date->short }}</td>
                        <td style="border-right: none; padding-right: 0.25rem;">
                            <form action="/fileapi/open" method="POST">
                                <input type="hidden" name="path" value="_posts/{{ $post->slug }}.md">
                                <input type="hidden" name="back" value="{{ request()->path() }}">
                                <button type="submit" title="Open in system editor" @disabled(! $app->windows)>Edit</button>
                            </form>
                        </td>
                        <td style="border-left: none; padding-left: 0.25rem;">
                            <form action="/open/_site" method="GET">
                                <input type="hidden" name="path" value="posts/{{ $post->slug }}.html">
                                <button type="submit" title="View with Realtime Compiler">View</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
