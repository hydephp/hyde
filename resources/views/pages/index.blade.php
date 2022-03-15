{{-- This is the default index.html file containing your latest blog posts --}}
@extends('layouts.app')
@section('content')

    <h1>{{ config('hyde.name') }}</h1>

    <section>
        <h2>Latest Posts</h2>
        
        @foreach(\App\Hyde\Models\MarkdownPost::getCollection() as $post)
        <article itemscope itemtype="https://schema.org/Article">
            <header>
                <h3 itemprop="headline">{{ $post->matter['title'] }}</h3>
                @includeWhen(isset($post->matter['date']), 'post.datePublished')
                @includeWhen(isset($post->matter['author']), 'post.author')
                @includeWhen(isset($post->matter['category']), 'post.category')
            </header>
            @includeWhen(isset($post->matter['description']), 'post.description')
            <footer>
                <a href="posts/{{ $post->matter['slug'] }}.html" itemprop="url">Read Post</a>
            </footer>
        </article>
        @endforeach

    </section>

@endsection
