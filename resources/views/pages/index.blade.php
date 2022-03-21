{{--
    This is the default index.html file containing your latest blog posts.
    If you want to use a custom index page a tip is to rename this file to `feed.blade.php`
    and you can customize this to your hearts desire!
--}}
@php($title = 'Latest Posts')
@extends('layouts.app')
@section('content')

<main class="mx-auto max-w-7xl py-12 px-8">
    <header class="lg:mb-12 xl:mb-16">
        <h1
        class="text-3xl text-left opacity-75 leading-10 tracking-tight font-extrabold sm:leading-none mb-8 md:mb-12 md:text-4xl md:text-center lg:text-5xl">
        Latest Posts</h1>
    </header>

    <div class="max-w-3xl mx-auto">
        @foreach(\Hyde\Framework\Models\MarkdownPost::getCollection() as $post)
        @include('components.article-excerpt')
        @endforeach
    </div>
</main>

@endsection
